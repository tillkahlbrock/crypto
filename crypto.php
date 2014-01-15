<?php

/**
 * @param $message
 * @param $publicKey
 * @return string the encrypted message
 */
function encrypt($message, $publicKey)
{
    list($e, $n) = $publicKey;
    $cipher = bcpowmod($message, $e, $n); // TODO: implement bcpowmod on my own
    echo "encrypt: " . $cipher . " = " . $message . '^' . $e . ' mod ' . $n . "\n";
    return $cipher;
}

/**
 * @param $cipher
 * @param $privateKey
 * @return string the decrypted cipher
 */
function decrypt($cipher, $privateKey)
{
    list($d, $n) = $privateKey;
    $message = bcpowmod($cipher, $d, $n);
    echo "decrypt: " . $message . " = " . $cipher . '^' . $d . ' mod ' . $n . "\n";
    return $message;
}

function extendedEuklid($a, $b)
{
    if ($b == 0) return array($a, 1, 0);

    list ($d, $s, $t) = extendedEuklid($b, ($a % $b));

    return array($d, $t, ($s - floor($a / $b) * $t));
}

function generateKeyPair($e = 65537)
{
    $p = 17; $q = 23; // TODO: generate large primes
    $n = $p * $q;
    $phiN = ($p-1) * ($q-1);

    list ($ggT, $d, $k) = extendedEuklid($e, $phiN);

    $privateKey = [$d, $n];
    $publicKey = [$e, $n];

    return array($privateKey, $publicKey);
}

/**
 * Testing stuff out
 */

list ($privateKey, $publicKey) = generateKeyPair();

$message = 245;

$cipher = encrypt($message, $publicKey);

$decryptedMessage = decrypt($cipher, $privateKey);

print_r(
    [
        'publicKey' => $publicKey,
        'privateKey' => $privateKey,
        'message' => $message,
        'cipher' => $cipher,
        'decryptedMessage' => $decryptedMessage
    ]
);