jQuery(document).ready(function($){
  function add_column_width_to_heading() {
    $('.widthHelper').remove();
    $('.acf-field-56bd005663e12').each(function() {
      var width = $(this).find('.acf-input select option:selected').text();
      var width = "<span class='widthHelper'> - " + width + "</span>";
      $(this).parent().siblings('.acf-fc-layout-handle').append(width);
    });
  }

  $(window).load(function() {
    add_column_width_to_heading();
  });

  $('.acf-fc-layout-handle').click(function() {
    function show_popup(){
      add_column_width_to_heading();
    };

    window.setTimeout( show_popup, 700 );
  });

  $(document).on('change', '.acf-field-56bd005663e12 select', function() {
    add_column_width_to_heading();
  });
  
  $('.layout[data-layout=additional_modules] .acf-fc-layout-handle').each(function() {
    $(this).append('<span class="module"> - ' + $(this).parent().find('.acf-field[data-key="field_588281987bc05"] option:selected').text() + '</span>');
  });
  
  $(document).on('change','.layout[data-layout=additional_modules] .acf-field-588281987bc05 select',function(){
    
    $(this).parent().parent().parent().parent().find('.acf-fc-layout-handle span.module').text(" - " + $(this).find('option:selected').text());

  });
  $('.acf-field-object[data-key="field_56bcfeb92630c"] > .handle > ul > li > strong > a.edit-field').click();
  
});
