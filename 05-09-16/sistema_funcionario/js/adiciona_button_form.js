 $(document).ready(function () {
                var i = 0;
                $('#add').live('click', function () {
                    if (i < 10)
                        $('form').append('<input id="seleciona_arquivo" type="file" name="files[]" id="files[]" /><br />');
                    i++;
                });
            });