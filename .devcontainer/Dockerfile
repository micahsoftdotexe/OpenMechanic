FROM mcr.microsoft.com/devcontainers/php:0-8.1

# Install MariaDB client

RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
    && apt-get install -y mariadb-client libpng-dev libzip-dev python3-pip curl\ 
    && apt-get clean -y && rm -rf /var/lib/apt/lists/*
RUN curl -fsSL https://deb.nodesource.com/setup_16.x | sudo -E bash -
RUN apt-get install -y nodejs
#nodejs npm
# Install php-mysql driver
RUN docker-php-ext-install mysqli pdo pdo_mysql
RUN docker-php-ext-install gd zip
#RUN npm install --global yarn
# RUN composer update
# RUN cd frontend/tuneup
# RUN yarn install
#RUN pip install pymysql

# [Optional] Uncomment this section to install additional OS packages.
# RUN apt-get update && export DEBIAN_FRONTEND=noninteractive \
#     && apt-get -y install --no-install-recommends <your-package-list-here>

# [Optional] Uncomment this line to install global node packages.
# RUN su vscode -c "source /usr/local/share/nvm/nvm.sh && npm install -g <your-package-here>" 2>&1

