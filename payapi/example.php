<?
  require_once("Paypal.php");
  $p = new Paypal();

  $p->SetEmail("user@email.com");
  $p->SetPassword("password");
  $p->SetCurrency("USD");
  
  // get balance when there is only one type
  // of currency
  $bal = $p->GetBalance();
  echo "<pre>My Balance: $bal<BR><BR>";

  // get balances where there are multiple currencies
  $bal = $p->GetMultipleBalances();    
  print_r($bal);

  // get all transactions and print them out
  $trans = $p->GetTransactions();
  print_r($trans);

?>