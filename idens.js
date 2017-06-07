//
//  Custom JS for Iden Ford
//  by Andrew@thinkupdesign.ca
//

jQuery( document ).ready(function( $ ) {

  openRequest();

  function openRequest(){
    $('a.unit-request').on("click", function(e){
      e.preventDefault();
      console.log('clicked!');
      $('div#request').slideDown('500');
    });
  }

});
