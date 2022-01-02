<?
// received result from paysbuy with data result,apCode,amt,fee,methos,confirm_cs
$result = $_POST["result"];
$len = strlen($result);
$payment_status = substr($result, 0,2);
$strInvoice = substr($result, 2,$len-2);
$apCode = $_POST["apCode"];
$amt = $_POST["amt"];
$fee = $_POST["fee"];
$method = $_POST["method"];
$confirm_cs = strtolower(trim($_POST["confirm_cs"]));
/* status result
00=Success
99=Fail
02=Process
*/
if ($payment_status == "00") {
    if ($method == "06") {
        if ($confirm_cs == "true") {
            echo "Success";
        } else if ($confirm_cs == "false") {
            echo "Fail";
        } else {
            echo "Process";
        }
    } else {
        echo "Success";
    }
} else if ($payment_status == "99") {
    echo "Fail";
} else if ($payment_status == "02") {
    echo "Process";
} else {
    echo "Error";
}
?>
