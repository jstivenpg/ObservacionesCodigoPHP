<?php
/**
 * @param string $code
 * @param string $cookie
 * @throws Exception
 */

 /* Argumento 1: Es mejor evitar asignar las variables en el momento que pasan por parametros,
  es mejor declara y asignar valores al inicio del código.*/
public function paymentDiscountProcesor($code = null, $cookie = null): void {

    // Define la variable si no esta definida.
    if (!isset($code)) {
    $code = $cookie;
  }
  if (isset($code) && !empty($code)) {
    /** @var Discount $discount */
    $discount = $this->modx->getObject('Discount', array('code' => $code));
    if (!empty($discount)) {
      $discAmmount = $discount->discount;cd
      $discExpire = $discount->expire;

      $expireDate = new DateTime($discExpire);
      $currentDate = new DateTime();

      // Este fragmento de código seria muy bueno realizarlo por Swith Case, para que sea mejor entendible.
      if (is_null($discExpire) || ($expireDate > $currentDate)) {
        if ($discAmmount == 100) {
          $this->modx->setPlaceholder('freeCode', 'freeCode');
        }
        $this->modx->setPlaceholder('validcode', $discAmmount . "% " . 'valid');
        echo '<script>window.disCode = ' . $discount->id . '</script>';
        echo '<script>window.discountCode = "' . $code . '"</script>';
        echo '<script>window.percentage = ' . $discAmmount . '</script>';
      } else {
        echo '<script>window.discountCode = "' . $code . '"</script>';
        $this->modx->setPlaceholder('errorcode', $code . " " . 'expired');
      }
    } else {
      echo '<script>window.discountCode = "' . $code . '"</script>';
      $this->modx->setPlaceholder('errorcode', $code . " " . 'notfound');
    }
  }
}

?>
