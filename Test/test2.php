<?php
         function getVoorraadTekst($actueleVoorraad) {
                 if ($actueleVoorraad > 1000) {
                 return "Ruime voorraad beschikbaar.";
                 } else {
                 return "Voorraad: $actueleVoorraad";
                 }
}

print(getVoorraadTekst(800));
print("\n");
print(getVoorraadTekst(999));
print('\n');
print(getVoorraadTekst(1000));
print('\n');
print(getVoorraadTekst(1001));
print('\n');
print(getVoorraadTekst(1200));
print('\n');
print(getVoorraadTekst(0));
print('\n');
print(getVoorraadTekst(-1000));