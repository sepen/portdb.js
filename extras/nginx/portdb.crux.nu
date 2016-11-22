#
# portdb.crux.nu
#

upstream api {
  server 127.0.0.1:8000;
}

upstream website {
  server 127.0.0.1:8080;
}

server {
  listen 80;
  server_name portdb.crux.nu;

  proxy_buffers 16 64k;
  proxy_buffer_size 128k;

  gzip on;
  gzip_http_version 1.1;
  gzip_vary on;
  gzip_comp_level 6;
  gzip_proxied any;
  gzip_types text/plain text/css application/json application/x-javascript text/xml application/xml application/xml+rss text/javascript application/javascript text/x-js;
  gzip_buffers 16 8k;

  location /api/ {
    proxy_pass http://api/;
    proxy_set_header Host $host;
    proxy_set_header X-Real-IP $remote_addr;
    proxy_set_header X-Forwarded-For $proxy_add_x_forwarded_for;
    proxy_set_header X-Forwarded-Proto http;
    proxy_redirect off;
    # allow only localhost connection without authentication 
    satisfy any;
    allow 127.0.0.1;
    deny all;
    auth_basic "portdb - Please authenticate";
    auth_basic_user_file /etc/nginx/htpasswd;
  }

  location / {
    proxy_pass http://website;
    proxy_set_header Cache-Control "no-cache";
    add_header Cache-Control "no-cache";
    add_header Access-Control-Allow-Origin *.domain;
    expires 0;
  }
}
