<html>
    <html lang="en">
        <head>
            <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/underscore.js/1.9.1/underscore-min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/backbone.js/1.3.3/backbone-min.js"></script>
            <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-GJzZqFGwb1QTTN6wy59ffF1BuGJpLSa9DkKMp0DgiMDm4iYMj70gZWKYbI706tWS" crossorigin="anonymous">
            <meta charset="UTF-8">
            <title>Share List</title>

        </head>
        <body>
            <?php
            if (!isset($_COOKIE['user_id'])) {
                redirect('/index_controller/index', 'refresh');
            }
            ?>
            <table class="table">
                <thead>
                    <tr>
                        <th>Title</th>
                        <th>URL</th>
                        <th>Price</th>
                        <th>Priority</th>
                    </tr>
                </thead>
                <?php foreach ($data as $row) { ?>

                    <tr>
                        <td><?= $row->title ?></td>
                        <td><?= $row->url ?></td>
                        <td><?= $row->price ?></td>
                        <td><?= $row->priority ?></td>
                    </tr>

                <?php } ?>
            </table>

        </body>
    </html>