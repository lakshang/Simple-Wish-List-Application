<!DOCTYPE html>
<html>
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>


        <title>Wish List </title>
    </head>
    <body>
        <div class="container">
            <div id="data">
                <h1>Welcome to Wish List</h1>
                <table>
                    <?php foreach ($list as $row) { ?>
                        <tr>
                            <td><?= $row->item_id ?></td>
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

            <p id="createmsg"></p>
            <p id="message"></p>

            <h3>Add to WishList</h3>

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
            <br><br>
            <form>
                <label for="edit"> Type in the id to delete/edit</label>
                <input type="text" name="id" id="id" size="10" /> <br>

                <input type="submit" value="Delete" id="delete" />
                <!--<input type="submit" value="Edit" id="edit" />-->
            </form>

            <script>
                //Add Backbone Code
                $(document).ready(function () {
                    var Create = Backbone.Model.extend({
                        url: function () {
                            var link = "<?php echo base_url(); ?>index.php/Api/addItems";
                            return link;
                        },
                        defaults: {
                            title: null,
                            descrip: null,
                            url: null,
                            price: null,
                            owner_id: null
                        }
                    });
                    var createModel = new Create();
                    var DisplayView = Backbone.View.extend({
                        el: ".container",
                        model: createModel,
                        initialize: function () {
                            this.listenTo(this.model, "sync change", this.gotdata);
                        },
                        events: {
                            "click #create": "getdata"
                        },
                        getdata: function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            var title = $("input#title").val();
                            var descrip = $("input#descrip").val();
                            var url = $("input#url").val();
                            var price = $("input#price").val();
                            var owner_id = $("input#owner_id").val();

                            this.model.set({title: title, descrip: descrip, url: url, price: price, owner_id: owner_id});
                            this.model.save();
                        },
                        gotdata: function () {
                            $('#createmsg').html('Name ' + this.model.get('title') + ' and address ' + this.model.get('title') + ' has been created').show();
                            $("#data").load(location.href + " #data");
                            $("input#title").val("");
                            $("input#descrip").val("");
                            $("input#url").val("");
                            $("input#price").val("");
                            $("input#owner_id").val("");
                        }
                    });
                    var displayView = new DisplayView();
                });

                $(document).ready(function () {
                    var Create = Backbone.Model.extend({
                        url: function () {
                            var link = "<?php echo base_url(); ?>index.php/Api/deleteItem";
                            return link;
                        },
                        defaults: {
                            item_id: null
                        }
                    });
                    var createModel = new Create();
                    var DisplayView = Backbone.View.extend({
                        el: ".container",
                        model: createModel,
                        initialize: function () {
                            this.listenTo(this.model, "sync change", this.gotdata);
                        },
                        events: {
                            "click #delete": "getdata"
                        },
                        getdata: function (event) {
                            event.preventDefault();
                            event.stopPropagation();
                            var id = $("input#id").val();
                            this.model.set({item_id: id});
                            this.model.save();
                        },
                        gotdata: function () {
                            $('#createmsg').html('Name ' + this.model.get('item_id') + ' and address ' + this.model.get('item_id') + ' has been created').show();
                            $("#data").load(location.href + " #data");
                            $("input#id").val("");

                        }
                    });
                    var displayView = new DisplayView();
                });

            </script>

        </div>
    </body>
</html>