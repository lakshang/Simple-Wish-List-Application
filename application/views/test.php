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
        <?php
        if (!isset($_COOKIE['user_id'])) {
            redirect('/index.php/index_controller/index', 'refresh');
        }
        ?>
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item logout-user">
                        <a class="nav-link" href="#">Logout</a>
                    </li>
                </ul>
            </div>
        </nav>
        <!--        <button class="btn btn-danger logout-user">Logout</button>-->
        <div class="container">
            <h3><?php
                if ($this->session->userdata('userlist_title') !== '') {
                    echo $this->session->userdata('userlist_title');
                }
                ?> Wishlist</h3>
            <h6><?php
                if ($this->session->userdata('userlist_descrip') !== '') {
                    echo $this->session->userdata('userlist_descrip');
                }
                ?></h6>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Price</th>
                        <th>Priority</th>
                        <th>Owner-Id</th>

                    <tr>
                        <td><input class="form-control title-input"></td>
                        <td><input class="form-control url-input"></td>
                        <td><input class="form-control price-input" type="number"></td>
<!--                        <td><input class="form-control priority-input"></td>-->
                        <td><select class="form-control priority-input">
                                <option  value="1">1 - High</option>
                                <option value="2">2 - Medium</option>
                                <option value="3">3 -Low</option>
                            </select></td>
                        <td><input class="form-control user-id" value="<?php echo $_COOKIE['user_id']; ?> " disabled="" ></td>
                        <td><button class="btn btn-primary add-item">Add</button></td>
                    </tr>
                </thead>
                <tbody class="items-list"></tbody>
            </table>
            <input type="button" value="Get the Share Link" class="btn btn-primary share-item" />
            <p id="share_url"></p>
        </div>

        <script type="text/template" class="items-list-template">
            <td><span class="title"><%= title %></span></td>
            <td><span class="url"><a href="<%= url %>"><%= url %></a></span></td>
            <td><span class="price">$<%= price %></span></td>
            <td><span class="priority"><%= priority %></span></td>
            <td><button class="btn btn-warning edit-item">Edit</button>
            <button class="btn btn-danger delete-item">Delete</button>
            <button class="btn btn-success update-item" style="display:none">Update</button>
            <button class="btn btn-danger cancel" style="display:none">Cancel</button>
            </td>
        </script>

        <script>
// Backbone Model
            var Item = Backbone.Model.extend({
                defaults: {
                    title: '',
                    url: '',
                    price: '',
                    priority: '',
                    user_id: ''
                }
            });
// Backbone Collection
            var Items = Backbone.Collection.extend({
                url: 'http://localhost/wish_list_application/list_controller/Item'
            });
// instantiate a Collection
            var items = new Items();
// Backbone View for one item
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
                    this.$('.title').html(title);
                    this.$('.url').html(url);
                    this.$('.price').html(price);
                    this.$('.priority').html('<input type="text" class="form-control priority-update" value="' + priority + '">');
                },
                update: function () {
                    this.model.set('priority', $('.priority-update').val());
                    if ($('.priority-update').val() === "1" || $('.priority-update').val() === "2" || $('.priority-update').val() === "3") {
                        this.model.save(null, {
                            success: function (response) {
                                items.fetch();
                                console.log('Successfully UPDATED');
                                alert('Update Successful');
                            },
                            error: function () {
                                console.log('Failed to UPDATED Item');
                            }
                        });
                    } else {
                        alert('Please select a proper priority (1-High/2-Medium/3-Low)');
                    }

                },
                cancel: function () {
                    itemsView.render();
                },
                delete: function () {
                    this.model.destroy({
                        success: function (response) {
                            console.log('Successfully DELTED item with id:' + response.toJSON().id);
                            alert('Item Delete Successful');
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
                                console.log('Successfully Loaded the Items ' + item.id);
                                console.log(<?php echo $_COOKIE['user_id']; ?>);
                            });
                        },
                        error: function () {
                            console.log('Failed to get items!');
                            console.log(<?php echo $_COOKIE['user_id']; ?>);
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
                    if ($('.title-input').val() === "" || $('.url-input').val() === "" || $('.price-input').val() === "") {
                        alert('Please enter all value');
                    } else {
                        console.log('get values');
                        var item = new Item({
                            title: $('.title-input').val(),
                            url: $('.url-input').val(),
                            price: $('.price-input').val(),
                            priority: $('.priority-input').val(),
                            user_id: $('.user-id').val()
                        });
                        $('.title-input').val('');
                        $('.url-input').val('');
                        $('.price-input').val('');
                        $('.priority-input').val('');
                        items.add(item);
                        item.save(null, {
                            success: function (response) {
                                items.fetch();
                                console.log('Item Added Successfully');
                            },
                            error: function (model, error) {
                                console.log('Failed to add Item!');
                                console.log(model.toJSON());
                            }
                        });
                    }
                });
            }); //Add button

            $(document).ready(function () {
                $('.logout-user').click(function (event) {
                    window.location.href = "<?php echo base_url(); ?>index_controller/logout";
                });
            });

            $(document).ready(function () {
                $('.share-item').click(function (event) {
                    var user_id = <?php echo $_COOKIE['user_id'] ?>;
                    $('#share_url').html("Your share link: <?php echo base_url() ?>list_controller/Share?id=" + user_id);
                });
            });
        </script>
    </body>
</html>