<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>产品筛选</title>
    <script>
        function submitForm() {
            document.getElementById('filterForm').submit();
        }
    </script>
</head>
<body>
    <h1>产品筛选</h1>
    <form method="POST" action="" id="filterForm">
        <label for="category">选择分类:</label>
        <select name="category" id="category" onchange="submitForm()">
            <option value="">所有分类</option>
            <option value="Electronics">电子产品</option>
            <option value="Books">书籍</option>
            <option value="Clothing">服装</option>
        </select>
    </form>

    <?php
    // PHP 代码处理表单提交和数据显示
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // 获取用户选择的分类
        $selectedCategory = $_POST['category'];

        // 连接数据库
        $servername = "localhost";
        $username = "your_username";
        $password = "your_password";
        $dbname = "your_database";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // 检查连接
        if ($conn->connect_error) {
            die("连接失败: " . $conn->connect_error);
        }

        // 根据用户选择的分类筛选产品
        if ($selectedCategory) {
            $sql = "SELECT id, name, category FROM products WHERE category = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $selectedCategory);
        } else {
            $sql = "SELECT id, name, category FROM products";
            $stmt = $conn->prepare($sql);
        }

        $stmt->execute();
        $result = $stmt->get_result();

        // 显示筛选后的数据
        if ($result->num_rows > 0) {
            echo "<table border='1'><tr><th>ID</th><th>产品名称</th><th>分类</th></tr>";
            while($row = $result->fetch_assoc()) {
                echo "<tr><td>" . $row["id"]. "</td><td>" . $row["name"]. "</td><td>" . $row["category"]. "</td></tr>";
            }
            echo "</table>";
        } else {
            echo "没有找到匹配的产品";
        }

        $stmt->close();
        $conn->close();
    }
    ?>
</body>
</html>

