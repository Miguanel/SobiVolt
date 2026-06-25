# Używamy oficjalnego, lekkiego obrazu PHP z wbudowanym serwerem Apache
FROM php:8.2-apache

# Kopiujemy wszystkie pliki z naszego folderu do publicznego katalogu serwera
COPY . /var/www/html/

# Otwieramy port 80 do komunikacji z przeglądarką
EXPOSE 80