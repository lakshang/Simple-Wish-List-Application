<!DOCTYPE html>
<html lang="en">
    <head>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>
        <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
        <meta charset="UTF-8">
        <title>Wish List</title>
    </head>
    <body>
        <div class="container">
            <br><br>
            <table>
                <tr>
                    <td>Username</td>
                    <td><input type="text" class="form-control username-input" required=""></td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td><input type="password" class="form-control password-input" required=""></td>
                </tr>
                <tr>
                <br>
                    <td><button class="btn btn-primary register-user">Register</button></td>
                    <td><button class="btn btn-success login-user">Login</button></td>
                </tr>
            </table>
        </div>
        <div class="container" style="display:none">
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Price</th>
                        <th>Priority</th>
                        <th>Action</th>
                    </tr>
                    <tr>
                        <td><input class="form-control title-input"></td>
                        <td><input class="form-control url-input"></td>
                        <td><input class="form-control price-input"></td>
                        <td><input class="form-control priority-input"></td>
                        <td><button class="btn btn-primary add-item">Add</button></td>
                    </tr>
                </thead>
                <tbody class="items-list"></tbody>
            </table>
        </div>

        <script type="text/template" class="items-list-template">
            <td><span class="title"><%= title %></span></td>
            <td><span class="url"><%= url %></span></td>
            <td><span class="price"><%= price %></span></td>
            <td><span class="priority"><%= priority %></span></td>
            <td><button class="btn btn-warning edit-item">Edit</button>
            <button class="btn btn-danger delete-item">Delete</button>
            <button class="btn btn-success update-item" style="display:none">Update</button>
            <button class="btn btn-danger cancel" style="display:none">Cancel</button>
            </td>
        </script>

        <script>
// Backbone Model
//            Backbone.Model.prototype.idAttribute = 'item_id';


            var Item = Backbone.Model.extend({
                defaults: {
                    title: '',
                    url: '',
                    price: '',
                    priority: ''
                }
            });
// Backbone Collection

            var Items = Backbone.Collection.extend({
                url: 'http://localhost/wish_list_application/index.php/test_controller/Item'
            });
// instantiate a Collection

            var items = new Items();
// Backbone View for one blog

            var ItemView = Backbone.View.extend({
                model: new Item(),
                tagName: 'tr',
                initialize: function () {
                    this.template = _.template($('.items-list-template').html());
                },
                events: {
                    'click .edit-item': 'edit',
                    'click .update-item': 'update',
                    'click .cancel': 'cancel',
                    'click .delete-item': 'delete'
                },
                edit: function () {
                    $('.edit-item').hide();
                    $('.delete-item').hide();
                    this.$('.update-item').show();
                    this.$('.cancel').show();
                    var title = this.$('.title').html();
                    var url = this.$('.url').html();
                    var price = this.$('.price').html();
                    var priority = this.$('.priority').html();
                    this.$('.title').html('<input type="text" class="form-control title-update" value="' + title + '" disabled>');
                    this.$('.url').html('<input type="text" class="form-control url-update" value="' + url + '" disabled>');
                    this.$('.price').html('<input type="text" class="form-control price-update" value="' + price + '" disabled>');
                    this.$('.priority').html('<input type="text" class="form-control priority-update" value="' + priority + '">');
                },
                update: function () {
                    this.model.set('priority', $('.priority-update').val());
                    this.model.save(null, {
                        success: function (response) {
                            console.log('Successfully UPDATED item with id:' + response.toJSON().item_id);
                        },
                        error: function () {
                            console.log('Failed to UPDATED Item');
                        }
                    });
                },
                cancel: function () {
                    itemsView.render();
                },
                delete: function () {
                    this.model.destroy({
                        success: function (response) {
                            console.log('Successfully DELTED item with id:');
                        },
                        error: function () {
                            console.log('Failed to DELETE Item');
                        }
                    });
                },
                render: function () {
                    this.$el.html(this.template(this.model.toJSON()));
                    return this;
                }
            });
// Backbone View for all blogs
            var ItemsView = Backbone.View.extend({
                model: items,
                el: $('.items-list'),
                initialize: function () {
                    var self = this;
                    this.model.on('add', this.render, this);
                    this.model.on('sync change', function () {
                        setTimeout(function () {
                            self.render();
                        }, 30);
                    }, this);
                    this.model.on('remove', this.render, this);
                    this.model.fetch({
                        success: function (response) {
                            _.each(response.toJSON(), function (item) {
                                console.log('Successfully Loaded the Items ');
                            });
                        },
                        error: function () {
                            console.log('Failed to get items!');
                        }
                    });
                },
                render: function () {
                    var self = this;
                    this.$el.html('');
                    _.each(this.model.toArray(), function (item) {
                        self.$el.append((new ItemView({model: item})).render().$el);
                    });
                    return this;
                }
            });
            var itemsView = new ItemsView();
            $(document).ready(function () {
                $('.add-item').on('click', function () {
                    var item = new Item({
                        title: $('.title-input').val(),
                        url: $('.url-input').val(),
                        price: $('.price-input').val(),
                        priority: $('.priority-input').val()
                    });
                    $('.title-input').val('');
                    $('.url-input').val('');
                    $('.price-input').val('');
                    $('.priority-input').val('');
                    items.add(item);
                    item.save({
                        success: function (response) {
                            _.each(response.toJSON(), function (item) {
                                console.log('Successfully Added an Item');
//                                $('.container').load(location.href + ' .container');
                            });
                        },
                        error: function () {
                            console.log('Failed to get items!');
                        }
                    });
                });
            });
        </script>
        <script>
            $(document).ready(function () {
                $(".login-user").click(function () {
                    $(".container").show("fast");
                });
            });
            
            $(document).ready(function(event)){
                
            }
            
        </script>

    </body>
</html>