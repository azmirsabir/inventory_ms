FROM composer:latest as composer_build
WORKDIR /app
COPY . /app
RUN composer install

FROM ubuntu/apache2:latest
COPY --from=composer_build /app/ /var/www/html/
RUN apt-get update && \
    apt-get install -y nano && \
    rm -fr /var/lib/apt/lists/*

RUN apt-get update && \
    apt-get install -y nano php php-cli php-common php-mysql php-zip php-gd php-mbstring php-curl php-xml php-bcmath && \
    rm -fr /var/lib/apt/lists/*

# Expose 443 (HTTPS)
EXPOSE 80

# Define the startup command (CMD)

#CMD ["apache2-foreground"]
