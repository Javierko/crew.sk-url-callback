<?php
$params = [
    'action',
    'method',
    'price',
    'currency',
    'days',
    'variables',
    'key',
    'code'
];

foreach($params as $param) {
    if(isset($_GET[$param])) {
        $params[$param] = $_GET[$param];
    }
}

# Klíč, který má být očekáváný při vytváření VIP brány
$expectedKey  = '';

/**
 * Zjistí o jakou akci se jedná
 * 
 * @var string
 * @return
 * - activate     Tato akce se zavolá pouze při úspěšném zakoupení VIP nebo při případném zavoláním manuálních callbacků
 * - deactivate   Tato akce se zavolá pouze tehdy, když vyprší dny @days
 */
$action = $params['action'];

/**
 * Zjistí přes jakou bránu se VIP zakoupilo
 * 
 * @var string
 * @return
 * - smssk      Platba pomocí Slovenské SMS brány
 * - smscz      Platba pomocí staré České SMS brány, již se nepoužívá a měla by být nefunkční
 * - smsczmb    Platba pomocí nové České SMS brány
 * - paypal     Platba pomocí PayPalu
 */
$method = $params['method'];

/**
 * Zjistí cenu VIP nikoli zisk z VIP
 * 
 * @var float
 * @return      Cena při zakoupení VIP
 */
$price = $params['price'];

/**
 * Měna, ve které bylo VIP zakoupeno
 * 
 * @var string
 * @return
 * - eur        Euro (Slovenská SMS / PayPal?)
 * - czk        Koruny (Česká SMS)
 */
$currency = $params['currency'];

/**
 * Počet dní na jak dlouho bude VIP aktivní
 * 
 * @var int
 * @return      Počet dní, není nutno nijak dělat odčítání po dni, stačí si nastavit callback na deaktivaci
 */
$days = $params['days'];

/**
 * Vlastní proměnné ve tvaru SMS, {nick}, {test}
 * 
 * @var array
 * @return
 * - promenna => hodnota
 */
$variables = $params['variables'];

/**
 * Klíč zadaný při vytváření URL callbacku, musí se shodovat s @code
 * 
 * @var string
 * @return      Klíč zadaný při URL callbacku
 */
$key = $params['key'];

/**
 * Klíč, který jste si vytvořili při vytváření VIP brány
 * 
 * @var string
 * @return      Klíč zadaný při VIP bráně
 */
$code = $params['code'];

if($key != $expectedKey) {
    exit("Špatný klíč, akce stornována");
}

# Zde nyní bude Váš kód pro různé akce, viz. složka "examples" (zde na GitHubu)