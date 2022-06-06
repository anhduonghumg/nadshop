<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.1.3/dist/css/bootstrap.min.css"
        integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.6.0.js"
        integrity="sha256-H+K7U5CnXl1h5ywQfKtSj8PCmoN9aaq30gDh27Xc0jk=" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="{{ url('public/client/js/pagination.js') }}"></script>
    <title>Document</title>
</head>

<body>
    <h1>Test paginate js</h1>
    <div id="data-container"></div>
    <div id="pagination-container"></div>

    <script type="text/javascript">
        $('#pagination-container').pagination({
        dataSource: [1, 2, 3, 4, 5, 6, 7,8,9,10,11,12,13,14,15,16,17,18,19,20],
        pageSize: 5,
        autoHidePrevious: true,
        autoHideNext: true,
        callback: function(data, pagination) {
            // template method of yourself
            var html = template(data);
            $('pagination-container').html(html);
            return false;
        }
    })
    </script>
</body>

</html>
