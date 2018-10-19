<?php
use yii\helpers\Url;
 ?>

<?php
$itemsJson = json_encode($modelPayment['items']);
$items     = preg_replace('/"([^"]+)"\s*:\s*/', '$1:', $itemsJson);
$this->registerJs("

    paypal.Button.render({

            env: '".Yii::$app->params['PaypalEnv']."', 

            style: {
            label: 'pay',
            size:  'responsive', // small | medium | large | responsive
            shape: 'pill',   // pill | rect
            color: 'gold'   // gold | blue | silver | black
        },
            client: {
                ".Yii::$app->params['PaypalEnv'].":    '".Yii::$app->params['PaypalClientKey']."', 
            },
            commit: true,
            payment: function(data, actions) {
                return actions.payment.create({
                    payment: {
                        transactions: [
                            {
                                amount: 
                                 {
                                    total: '".$modelPayment['total_price']."',
                                    currency: '".$modelPayment['currency']."',
                                 },
                                item_list: {
                                        items: ".$items.",
                                }
                            }
                        ]
                    }
                });
            },


            onAuthorize: function(data, actions) {
                
                // Make a call to the REST api to execute the payment
                return actions.payment.execute().then(function(data) {
                    $('#title-container').html('Please Wait a moment...')
                     $('#radio-payment-container').html('<center><img src=/img/loading.svg></center>');
                     $.ajax({
                         url : '".Url::to(["/reservation/paypal-success"])."',
                         type: 'POST',
                         async: 'true',
                         data: {umk: data},
                   });

                });
            },

             onCancel: function (data, actions) {
                alert('Payment Cancelled By User');
             },

             onError: function (data, actions) {
                location.reload();
             }

        }, '#hasil-ajax');
");

?>
<center>
    <div class="col-md-12"><b class="font-bold"><?= $modelPayment['currency']." ".number_format($modelPayment['total_price'],0) ?></b></div>
    <div class="col-md-12" id="hasil-ajax"></div>
</center>



