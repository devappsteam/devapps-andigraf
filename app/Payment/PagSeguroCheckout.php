<?php
namespace App\Payment;

class PagSeguroCheckout
{
    private $currency;
    private $items;
    private $reference;
    private $redirectURL;

    public function __construct($currency, $items, $reference, $redirectURL)
    {
        $this->currency = $currency;
        $this->items = $items;
        $this->reference = $reference;
        $this->redirectURL = $redirectURL;
    }

    public function buildXml()
    {
        $xml = '<?xml version="1.0" encoding="UTF-8" standalone="yes"?>';
        $xml .= '<checkout>';
        $xml .= '<currency>' . $this->currency . '</currency>';
        $xml .= '<items>';

        foreach ($this->items as $item) {
            $xml .= '<item>';
            $xml .= '<id>' . $item['id'] . '</id>';
            $xml .= '<description>' . $item['description'] . '</description>';
            $xml .= '<amount>' . $item['amount'] . '</amount>';
            $xml .= '<quantity>' . $item['quantity'] . '</quantity>';
            $xml .= '</item>';
        }

        $xml .= '</items>';
        $xml .= '<reference>' . $this->reference . '</reference>';
        $xml .= '<redirectURL>' . $this->redirectURL . '</redirectURL>';
        $xml .= '</checkout>';

        return $xml;
    }
}
?>
