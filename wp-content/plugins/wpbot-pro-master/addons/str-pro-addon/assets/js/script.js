jQuery(document).ready(function($){

    $('#users_answer_add_new').on('click', function(e){
        e.preventDefault();

        var intents = $('#qc_str_clone_intents').clone().html();
        var html = `<div class="users_answer_item">
                    <input type="text" name="users_answer[answer][]" placeholder="User answers, Hash(#) seperated" />
                    <select name="users_answer[feedback][]">${intents}</select>
                    <span class="users_answer_close">x</span>
                </div>`;
        $('#users_answer_container').append( html );
    })

    $(document).on('click', '.users_answer_close', function(e) {
        e.preventDefault();
        $(this).parent().remove();
    })
    $('.str-hide-advance').hide();
    $('.form-table').on('click', '.str_advance_settings', function(e) {
      
        $('.str-hide-advance').show();
        $('.str_advance_settings').hide();
    })
})