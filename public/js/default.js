$(function() {
    $(".todos").sortable({
        axis:   'y',
        containment: 'window',
        update: function() {
            var arr = $('.todos').sortable('toArray');

            arr = $.map(arr, function(val, key) {
                return val.replace('todo-','');
            });

            $.ajax('/todoapp/todo/rearrange',{
                data: {
                    positions: arr
                },
                type: 'GET',
                cache: false
            });
        }
    });

    $('#addTodoBtn').click(function(e) {
        $.post('/todoapp/todo/add', {
            name: 'New Todo Item'
        },
        function(data) {
            var liHtml = '<li id="todo-'+data.id+'" class="todo"><div class="text">'+data.name+'</div><div class="actions"><a href="#" class="edit"><i class="icon-edit"></i> Edit</a><a href="#" class="delete"><i class="icon-trash"></i> Delete</a></div></li>';
            $(liHtml).hide().appendTo('.todos').fadeIn();
        });

        e.preventDefault();
    });
});

$(document).on('click', '.todo a.delete', function (e) {
    var currentTodo = $(this).closest('.todo');

    if (confirm('Are you sure you want to delete this todo?')) {
        $.get('/todoapp/todo/delete',{
                id: currentTodo.attr('id').replace('todo-','')
            },
            function(msg) {
                currentTodo.fadeOut('fast');
            });
    }
});

$(document).on('click', '.todo a.edit', function(e) {
    var currentTodo = $(this).closest('.todo');
    currentTodo.data('id', currentTodo.attr('id').replace('todo-',''));

    var container = currentTodo.find('.text');
    if (!currentTodo.data('origText')) {
        currentTodo.data('origText', container.text());
    } else {
        return false;
    }

    $('<input type="text" />').val(container.text()).appendTo(container.empty());

    var editTodo = $('<div />').addClass('editTodo').append($('<a />').addClass('saveChanges').attr('href','#').html('Save')).
        append(' or ').
        append($('<a />').attr('class','discardChanges').attr('href','#').html('Cancel')
    );

    container.append(editTodo);
});

$(document).on('click', '.todo a.discardChanges', function(e) {
    var currentTodo = $(this).closest('.todo');
    currentTodo.data('id', currentTodo.attr('id').replace('todo-',''));

    currentTodo.find('.text').text(currentTodo.data('origText')).end().removeData('origText');
});

$(document).on('click', '.todo a.saveChanges', function(e) {
    var currentTodo = $(this).closest('.todo');

    var text = currentTodo.find("input[type=text]").val();

    $.post("/todoapp/todo/save", {
        id: currentTodo.attr('id').replace('todo-',''),
        name: text
    });

    currentTodo.removeData('origText').find('.text').text(text);
});