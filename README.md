ain
===

Generate the SSH keys for Auth:
    
    $ openssl genrsa -out var/jwt/private.pem -aes256 4096
    $ openssl rsa -pubout -in var/jwt/private.pem -out var/jwt/public.pem
