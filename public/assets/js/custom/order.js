$(document).ready(function(){

    $('.add-product-btn').on('click',function(e){

        e.preventDefault();
        
     let name = $(this).data('name');
     let price = $(this).data('price');
     let id = $(this).data('id');

     $(this).removeClass('btn-success').addClass('btn-default disabled');

    let orderDetails = `<tr>
    <td>${name}</td>
    <td><input type="number" name="products[${id}][quantity]" data-price="${price}" class="form-control input-sm product-quantity" min="1" value="1"></td>
    <td class="product-price">${price}</td>               
    <td><button class="btn btn-danger btn-sm remove-product-btn" data-id="${id}"><span class="fa fa-trash"></span></button></td>
     </tr>`; 
     
     $('.order-list').append(orderDetails);
        
     calculateTotal();
        }); //end of add product btn


        $('body').on('click', '.remove-product-btn',function(e){

        e.preventDefault();
       
        let id = $(this).data('id');

        $(this).closest('tr').remove();

        $('#product-' + id).removeClass('btn-default disabled').addClass('btn-success');

        calculateTotal();

  
       });  //end of delete btn


       $('body').on('keyup change','.product-quantity',function(){

     let quantity = parseInt($(this).val());
     let unitPrice = $(this).data('price');
     $(this).closest('tr').find('.product-price').html($.number(quantity * unitPrice, 2));
    
     calculateTotal();
       });


       $('.order-products').on('click',function(e){

         e.preventDefault();
         $('#loading').css('display', 'flex');

         let id = $(this).data('id');

         $.ajax({
          type : 'get',
          url : '/dashboard/orders/products' +id,

          success:function(data){


            $('#loading').css('display', 'none');

            $('#order-product-list').empty();
            
            $('#order-product-list').append(data);

          }

         });



       });

       $(document).on('click','.print-btn',function(){

         $('#print-area').printThis();
       });









}); //end of ready

function calculateTotal()
{
    let price = 0;

   $('.order-list .product-price').each(function(index) {
      
      price += parseFloat($(this).html().replace(/,/g, ''));
   });

  $('.total-price').html($.number(price,2));

  if (price > 0)
  {
       $('#add-order-form-btn').removeClass('disabled');
  }else{
      
   $('#add-order-form-btn').addClass('disabled');


  }

} //end of calculateTotal