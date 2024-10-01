<?php
include '../../NSS_NEW/partial/_dbconnector.php';

session_start();

if (!isset($_SESSION['Admin_loggedin']) || $_SESSION['Admin_loggedin'] != true) {
    header("location: login.php");
    exit;
}

?>

<?php
require '../../NSS_NEW/partial/_dbconnector.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST["transaction_type"]) && isset($_POST["description"]) && isset($_POST["amount"])) {
        $transactionType = $_POST["transaction_type"];
        $description = $_POST["description"];
        $amount = $_POST["amount"];
        echo $transactionType;

        $insertQuery = "INSERT INTO transactions (transaction_type, description, amount) VALUES ('$transactionType', '$description', $amount)";
        mysqli_query($conn, $insertQuery);
    }
}

$selectIncomeQuery = "SELECT SUM(amount) as total_income FROM transactions WHERE transaction_type = 'income'";
$selectExpenseQuery = "SELECT SUM(amount) as total_expense FROM transactions WHERE transaction_type = 'expense'";

$resultIncome = mysqli_query($conn, $selectIncomeQuery);
$resultExpense = mysqli_query($conn, $selectExpenseQuery);

$totalIncome = mysqli_fetch_assoc($resultIncome)['total_income'];
$totalExpense = mysqli_fetch_assoc($resultExpense)['total_expense'];

$balance = $totalIncome - $totalExpense;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <link rel="stylesheet" href="../CSS/style.css">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }

        .summary-card {
            width: 300px;
            margin: 0 auto;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .summary-card .card-header {
            background-color: #007bff;
            color: #fff;
            font-weight: bold;
        }

        .summary-card .card-body {
            background-color: #f8f9fa;
        }

        .summary-card p {
            margin-bottom: 10px;
        }
    </style>
</head>

<body id="body">
    <?php include '../../NSS_NEW/partial/_header.php'; 
    ?><br><br>


    <div class="container mt-5">
        <h2 class="text-center mb-4">Expense Tracker</h2>

        <!-- Add Transaction Form -->
        <div class="card mb-4">
            <div class="card-header">
                Add Transaction
            </div>
            <div class="card-body">
                <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                    <div class="form-group">
                        <label for="transactionType">Transaction Type:</label>
                        <select class="form-control" id="transactionType" name="transaction_type" required>
                            <option selected disabled>Select Type</option>
                            <option value="expense">Expense</option>
                            <option value="income">Income</option>

                        </select>
                    </div>
                    <div class="form-group">
                        <label for="description">Description:</label>
                        <input type="text" class="form-control" id="description" name="description" required>
                    </div>
                    <div class="form-group">
                        <label for="amount">Amount:</label>
                        <input type="number" class="form-control" id="amount" name="amount" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Add Transaction</button>
                </form>
            </div>
        </div>

        <!-- Transaction List -->
        <div class="mt-4">
            <h3 class="text-center">Transaction History</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Transaction Type</th>
                        <th>Description</th>
                        <th>Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $selectQuery = "SELECT * FROM transactions WHERE transaction_type = 'expense'";
                    $result = mysqli_query($conn, $selectQuery);

                    while ($row = mysqli_fetch_assoc($result)) {
                        echo "<tr>";
                        echo "<td>{$row['transaction_type']}</td>";
                        echo "<td>{$row['description']}</td>";
                        echo "<td>{$row['amount']}</td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <!-- Display total income, pending, and total expense -->
        <div class="card mt-4 text-center summary-card">
            <div class="card-header">
                Summary
            </div>
            <div class="card-body">
                <p class="card-text">Total Income: <?php echo $totalIncome; ?></p>
                <p class="card-text">Total Expense: <?php echo $totalExpense; ?></p>
                <p class="card-text">Pending: <?php echo $balance; ?></p>
            </div>
        </div>
    </div>
    <br><br>
    <?php include '../../NSS_NEW/partial/_footer.php'; ?>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>