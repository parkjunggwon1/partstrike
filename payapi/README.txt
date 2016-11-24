aPapi - A Paypal API - v1.1

A Paypal API is a class written in PHP that allows website 
developers and other PHP users to retreive their Paypal
account balance and recent transactions from the Paypal 
server.

This might be useful if you're having a fund raising event
and want to display the current balance and last donater on
your own website

aPapi uses the program curl to get the data. It automatically
checks whether it can use PHP built in curl or the actual program
curl automatically. 

To use aPapi see the example.php file. 

You just need to include the Paypal file, then initialize the class.
Set your email and password, then get the balance


  require_once("Paypal.php");
  $p = new Paypal(); 
  
  $p->SetEmail("email@test.com");
  $p->SetPassword("mypass");
  $p->SetCurrency("USD");
  
The balance is saved in a scalar variable.

  $bal = $p->GetBalance();

The recent transactions are saved in an array of arrays. In
the example.php, the transactions are saved in the array. You 
can see the structure of the array with the print_r()
function.
 
   $trans = $p->GetTransactions();
  
But for those of you who are lazy, this is the array structure

Array
(
    [0] => Array
        (
            [type] =>  Payment
            [tofrom] =>  From
            [nameemail] =>  John Smith
            [date] =>  May 9, 2005
            [status] =>  Completed
            [amount] => $1,000.00 USD 
            [fee] => -$29.30 USD 
        )

    [1] => Array
        (
            [type] =>  Payment
            [tofrom] =>  From
            [nameemail] =>  Joe Everyman
            [date] =>  May 4, 2005
            [status] =>  Completed
            [amount] => $5.00 USD 
            [fee] => -$0.45 USD 
        )
)


If you have a Paypal account that stores multiple currencies at 
the same time, then the regular GetBalance() won't work for you. 
Instead, you should use

	$balances = $p->GetMultipleBalances();
	
This returns an array of the pair [amount, currency name], so that
the array structure looks like

Array
(
    [0] => Array
        (
            [0] => 533.40
            [1] => USD
        )

    [1] => Array
        (
            [0] => 0.20
            [1] => EUR
        )
)

