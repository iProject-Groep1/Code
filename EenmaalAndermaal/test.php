<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

        <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>

        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>

    </head>
    <body>

        <select id="address" style="width:500px;"></select>

        <script type="text/javascript">
    $(document).ready(function(){

        $("#submit").click(function(){
            var val = $("#address").val();
            alert(val);
        });

        $('select').select2({
                    placeholder: "Search for your city",
                    ajax: {
            url: function(params){
                return 'api.php?data='+params.term;
            },
            dataType: 'json',
                        processResults: function (data) {
                return {
                    results: $.map(data, function (item) {
                        return {
                            text: item.text,
                                        id: item.text
                                    }
                                })
                            };
                        }
                    }

                });
            });
        </script>

    </body>
</html>