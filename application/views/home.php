<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <title>Wish List </title>
    </head>
    <body>
        <div id="container">
            <div id="data">
                <h1>Welcome to Wish List</h1>
                <table>
                    <?php foreach ($list as $row) { ?>
                        <tr>
                            <td><?= $row->id ?></td>
                            <td><?= $row->title ?></td>
                            <td><?= $row->descrip ?></td>
                            <td><?= $row->url ?></td>
                            <td><?= $row->price ?></td>
                            <td><?= $row->owner_id ?></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>
            <hr>
            <form>
                <label for='title'>Title</label>
                <input type="text" name="title" id="title" size="30"/><br>

                <label for='descrip'>Description</label>
                <input type="text" name="descrip" id="descrip" size="30"/><br>

                <label for='url'>URL</label>
                <input type="text" name="url" id="url" size="30"/><br>

                <label for='price'>Price</label>
                <input type="text" name="price" id="price" size="30"/><br>

                <label for='owner_id'>Owner Id</label>
                <input type="text" name="owner_id" id="owner_id" size="30"/><br>

                <input type="submit" value="Create" id="create"/>

            </form>

            <script>
                $(document).ready(function () {
                    
                    $("#create").click(function (event) {
                        event.preventDefault();
                        var title = $("input#title").val();
                        var descrip = $("input#descrip").val();
                        var url = $("input#url").val();
                        var price = $("input#price").val();
                        var owner_id = $("input#owner_id").val();
                        $.ajax({
                            method: "POST",
                            url: "<?php echo base_url(); ?>index.php/Api/addItems",
                            dataType: 'JSON',
                            data: {title: title, descrip: descrip, url: url, price: price, owner_id: owner_id},
                            success: function (data) {
                                console.log(title, descrip, url, price, owner_id);
                                $("#data").load(location.href+ " #data");
                            }
                        });
                    });
                });
            </script>

        </div>
    </body>
</html>