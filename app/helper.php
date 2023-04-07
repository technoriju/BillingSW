<?php
   use App\Models\Product;
   use Carbon\Carbon;

   if(!function_exists('r')):
      function r($data)
      {
         echo "<pre>";
         print_r($data->toArray());
         echo "<pre>";
      }
   endif;

   if(!function_exists('f')):
    function f($data)
    {
       echo "<pre>";
       print_r($data);
       echo "<pre>";
    }
   endif;

  function uppercase($string)
  {
    return ucwords($string);
  }

  function dateFormat($date)
  {
    return date('d-m-Y',strtotime($date));
  }

  function productNQP($product_id)
  {
    return Product::select('product_name','qty','purchase_price')->where('product_id',$product_id)->first();
  }

  function curDate()
  {
     return date('Y-m-d H:i:s');
  }

  function next30Date($date)
  {
     return date("Y-m-d", strtotime($date ."+30 days"));
  }


?>
