<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-3d"></script>

<?php
include_once("../config/config.php");
include_once(DIR_URL."/db/dbConnection.php");
include_once(DIR_URL."/includes/header.php");
?>
<?php if(isset($_SESSION['is_logged_in'])){?>
<?php

include_once(DIR_URL."/includes/navbar.php");
include_once(DIR_URL."/includes/sidebar.php");


$branchId = $_SESSION['user_branch_id'];

$fromDate = date("Y-m")."-01";
$todayDate = date("Y-m-d");

function formatIndianNumber($num) {
    $num = (int) $num; // Ensure it's an integer
    return preg_replace('/\B(?=(\d{2})+(?!\d))/', ',', $num);
}


function formatIndianCurrency($number) {
    $exploded = explode('.', $number); // Separate decimal part if exists
    $intPart = $exploded[0]; // Get the integer part
    $decimalPart = isset($exploded[1]) ? '.' . $exploded[1] : ''; // Decimal if exists

    // Format as per Indian numbering system
    $formattedNumber = preg_replace('/(\d)(?=(\d\d)+\d$)/', '$1,', $intPart);
    
    return '₹ ' . $formattedNumber . $decimalPart . ' /-';
}







$querySearchTodaySales = "select sum(s_net_amount) as total_amount, sum(s_qty) as total_qty from sales_summary where date(sales_date) = '$todayDate' and branch_id = '$branchId'";

$resultSearchTodaySales  = $con->query($querySearchTodaySales)->fetch_assoc();

$querySearchTodayPurchase = "select sum(net_amount) as purchase_amount, sum(total_qty) as purchase_qty from purchase_summary where date(grn_date) = '$todayDate' and branch_id = '$branchId'";

$resultSearchTodayPurchase  = $con->query($querySearchTodayPurchase)->fetch_assoc();

$querySearchMonthSales = "select sum(s_net_amount) as month_amount, sum(s_qty) as month_qty from sales_summary where date(sales_date) between  '$fromDate' and '$todayDate' and branch_id = '$branchId'";

$resultSearchMonthSales = $con->query($querySearchMonthSales)->fetch_assoc();




// For Today's Sales Chart Start

$querySearchDaySalesChart = "select*from sales_summary where  date(sales_date) = '$todayDate' 
                    and branch_id = '$branchId' order by sales_number";

$resultSearchDaySalesChart = $con->query($querySearchDaySalesChart);

$daySalesBillNumber = [];
$daySalesBillAmount = [];
while($daySalesData = $resultSearchDaySalesChart->fetch_assoc()){
    $daySalesBillNumber[] = ltrim(substr($daySalesData['sales_number'],-6),0);
    $daySalesBillAmount[] = $daySalesData['s_net_amount'];

}

$max_billAmount_json = 0;
$num_values_in_array = 0;
$average_billAmount_json = 0; 

$billNumberDaySales_json = 0;
$billAmountDaySales_json = 0;

if(count($daySalesBillAmount) >0 && count($daySalesBillNumber)>0){
$max_billAmount_json =  max($daySalesBillAmount);
$num_values_in_array =  count($daySalesBillAmount);

$min_billAmount_json = min($daySalesBillAmount);

$average_billAmount_json = (max($daySalesBillAmount)+min($daySalesBillAmount))/$num_values_in_array;


$billNumberDaySales_json = json_encode($daySalesBillNumber);
$billAmountDaySales_json = json_encode($daySalesBillAmount);

}



// For Today's Sales Chart End



// For Today's Purchase Chart Start

$querySearchDayPurchaseChart = "select*from purchase_summary where  date(grn_date) = '$todayDate' 
                    and branch_id = '$branchId' order by grn_number";

$resultSearchDayPurchaseChart = $con->query($querySearchDayPurchaseChart);

$grnNumber = [];
$grnAmount = [];
while($dayPurchaseData = $resultSearchDayPurchaseChart->fetch_assoc()){
    $grnNumber[] = ltrim(substr($dayPurchaseData['grn_number'],-6),0);
    $grnAmount[] = $dayPurchaseData['net_amount'];

}

$grnNumber_json = json_encode($grnNumber);
$grnAmount_json = json_encode($grnAmount);

// For Today's Purchase Chart End


// For Month Sales Chart Start

$querySearchMonthSalesChart = "select*from sales_summary 
where date(sales_date)  between  '$fromDate' and '$todayDate' and branch_id = '$branchId'";

$resultSearchMonthSalesChart = $con->query($querySearchMonthSalesChart);

$billDate = [];
$billAmount = [];
while($monthSalesData = $resultSearchMonthSalesChart->fetch_assoc()){
    $billDate[] = date("d-m-Y",strtotime($monthSalesData['sales_date']));
    $billAmount[] = $monthSalesData['s_net_amount'];

}

$billDate_json = json_encode($billDate);
$billAmount_json = json_encode($billAmount);

// For Month Sales Chart End

?>
<?php 



?>



<script>

// Bar Chart - 'bar'
// Line Chart - 'line'
// Pie Chart - 'pie'
// Doughnut Chart - 'doughnut'
// Radar Chart - 'radar'
// Polar Area Chart - 'polarArea'
// Bubble Chart - 'bubble'
// Scatter Chart - 'scatter'



window.onload = function () {
    var ctx = document.getElementById('myChart')?.getContext('2d');

    // Create a gradient color
    var gradient = ctx.createLinearGradient(0, 0, 0, 400);
    gradient.addColorStop(0, '#FF3CAC');  // Start color
    gradient.addColorStop(0.5, '#784BA0'); // Middle color
    gradient.addColorStop(1, '#2B86C5');  // End color

    // Get current date
        let todayDate =  new Date();
    let currentDate = todayDate.getDate().toString()+"-"+(todayDate.getMonth()+1).toString().padStart(2,"0")+"-"+todayDate.getFullYear();

    // Set canvas size
    var canvas = document.getElementById('myChart');
    canvas.width = 1800;
    canvas.height = 600;

    var barChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: <?php echo $billNumberDaySales_json;?>, 
            datasets: [{
                label: 'Bill Amount',
                data:<?php echo $billAmountDaySales_json;?>,
                backgroundColor: gradient,
                // barThickness: 40,  // Set a fixed bar height (default is auto)
                // maxBarThickness: 60 // Optional: Maximum bar thickness

            }]
        },
        options: {
            plugins: {
                title: {
                    display: true,
                    text: ["Today's Sales", currentDate],  // Multiple Titles
                    font: {
                        size: 20
                    },
                    padding: {
                        top: 10,
                        bottom: 30
                    }
                }
            },
            scales: {
                x: {
                    

                
                    title: {
                        display: true,
                        text: 'Bill Number'  // X-axis label
                    }
                },
                y: {
                    title: {
                        display: true,
                        text: 'Amount (₹)'  // Y-axis label
                    },
                    // min:1,
                    // max:<?php echo $max_billAmount_json; ?>,
                    // ticks:{
                    //     stepSize:<?php echo $average_billAmount_json; ?>
                    // }
                }
            }
        }
    });
}







</script>


<body style="background-color:aliceblue">
    
    <div style="display:flex;width:1255px;gap:15px;height:220px;margin-left:262px">
    
            <div style="width:34%;margin-top:30px;margin-left:2px" id="">
                <div class="card mb-3" style="max-width: 540px;height:180px;border-radius:px" id="todaySales" onclick="">
                      <div class="row g-0">
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title" style="font-weight: bolder;font-size:20px;text-align:center;width:370px">Today's Sales</h5>
                            
                            <p class="card-text" style="font-size:40px;font-weight:bolder;text-align:center;width:370px;margin-top:10px">
                            <?php echo isset($resultSearchTodaySales['total_amount'])?formatIndianCurrency($resultSearchTodaySales['total_amount']):0; ?></p>
                            
                            <p class="card-text" style="font-size:large;font-weight:bolder;text-align:center;width:370px">Qty - 
                            <?php echo isset($resultSearchTodaySales['total_qty'])?$resultSearchTodaySales['total_qty']:0; ?>
                            </p>
                          </div>
                        </div>
                      </div>
                </div>
                
            
            </div>
            <?php if($_SESSION['user_role']!= "User"){?>
            <div style="width:34%;margin-top:30px;">
            <div class="card mb-3" style="max-width: 540px;height:180px;" id="todayPurchase"
            onclick="">
                      <div class="row g-0">
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title" style="font-weight: bolder;font-size:20px;text-align:center;width:370px">Today's Purchase</h5>
                            
                            <p class="card-text" style="font-size:40px;font-weight:bolder;text-align:center;width:370px;margin-top:10px">
                            <?php echo isset($resultSearchTodayPurchase['purchase_amount'])?formatIndianCurrency($resultSearchTodayPurchase['purchase_amount']):0; ?></p>
                            
                            <p class="card-text" style="font-size:large;font-weight:bolder;text-align:center;width:370px">Qty - 
                            <?php echo isset($resultSearchTodayPurchase['purchase_qty'])?$resultSearchTodayPurchase['purchase_qty']:0; ?>
                            </p>
                          </div>
                        </div>
                      </div>
            </div>
            </div>
            <div style="width:34%;margin-top:30px">
            <div class="card mb-3" style="max-width: 540px;height:180px;" id="monthSales"
            onclick="">
                      <div class="row g-0">
                        <div class="col-md-8">
                          <div class="card-body">
                            <h5 class="card-title" style="font-weight: bolder;font-size:20px;text-align:center;width:370px">This Month Sales</h5>
                            
                            <p class="card-text" style="font-size:40px;font-weight:bolder;text-align:center;width:370px;margin-top:10px">
                            <?php echo isset($resultSearchMonthSales['month_amount'])?formatIndianCurrency($resultSearchMonthSales['month_amount']):0; ?></p>
                            
                            <p class="card-text" style="font-size:large;font-weight:bolder;text-align:center;width:370px">Qty - 
                            <?php echo isset($resultSearchMonthSales['month_qty'])?$resultSearchMonthSales['month_qty']:0; ?>
                            </p>
                          </div>
                        </div>
                      </div>
            </div>
                
                
            
            </div>
            <?php }?>
        
    </div>
   
    <div style="display:flex;width:1255px;background-color:aliceblue;height:420px;margin-left:262px">
    
        
    <canvas id="myChart"></canvas>
    

        
        
    </div>
    
</body >



<?php include_once(DIR_URL."/includes/footer.php")?>

<?php }else{
    // header("Location:".BASE_URL."index.php");
}
?>

<style>
#todaySales{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border:none;
    
}


#todayPurchase{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border:none;
    
}
#monthSales{
    background-color: #FF3CAC;
    background-image: linear-gradient(225deg, #FF3CAC 0%, #784BA0 50%, #2B86C5 100%);
    color: white;
    border:none;
}
</style>