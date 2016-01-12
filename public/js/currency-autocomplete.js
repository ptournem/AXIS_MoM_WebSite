$(function(){
  var currencies = [
    { value: 'Le sacre de Napoléon', data: 'AFN' },
    { value: 'La Joconde', data: 'ALL' },
    { value: 'Jacques Louis David', data: 'DZD' },
    { value: 'Stèle funéraire de Théodore', data: 'EUR' },
    { value: 'Plaque et décor égyptisant', data: 'AOA' },
    { value: 'L\'adorant de Larsa', data: 'AOA' },
  ];
  
  // setup autocomplete function pulling from currencies[] array
  $('#autocomplete').autocomplete({
    lookup: currencies,
    onSelect: function (suggestion) {
      var thehtml = '<strong>Currency Name:</strong> ' + suggestion.value + ' <br> <strong>Symbol:</strong> ' + suggestion.data;
      $('#outputcontent').html(thehtml);
    }
  });
  

});
