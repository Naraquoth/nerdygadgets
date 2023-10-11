<?php
         function getVoorraadTekst($actueleVoorraad) {
                 if ($actueleVoorraad >= 1000) {
                 return "Ruime voorraad beschikbaar.";
                 } else {
                 return "Voorraad: $actueleVoorraad";
                 }
}

var_dump(getVoorraadTekst(800));
print("\n");
var_dump(getVoorraadTekst(999));
print("\n");
var_dump(getVoorraadTekst(1000));
print("\n");
var_dump(getVoorraadTekst(1001));
print("\n");
var_dump(getVoorraadTekst(1200));
print("\n");
var_dump(getVoorraadTekst(0));
print("\n");
var_dump(getVoorraadTekst(-1000));