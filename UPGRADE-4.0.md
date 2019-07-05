UPGRADE FROM 3.x to 4.0
=======================

The 4.0 release of this package bumps the `imgix/imgix-php` dependency to `^3.0`, which drops the support for domain sharding. Sharding was [deprecated in May 2019](https://blog.imgix.com/2019/05/03/deprecating-domain-sharding) reflecting the wide availability of HTTP/2.

Nothing in the code has to change, but the bundle configuration must be updated to define a single domain name, not an array of domain names.

Configuration for **<4.0**:
---

```
parameters:
    env(IMGIX_ENABLED): false
    env(IMGIX_DOMAIN): ''

tacticmedia_imgix:
    enabled: '%env(IMGIX_ENABLED)%'
    sources:
        default:
            domains: ['%env(IMGIX_DOMAIN)%']
```

Configuration for **^4.0**:
---

```
parameters:
    env(IMGIX_ENABLED): false
    env(IMGIX_DOMAIN): ''

tacticmedia_imgix:
    enabled: '%env(IMGIX_ENABLED)%'
    sources:
        default:
            domain: '%env(IMGIX_DOMAIN)%'
```

The `domains` (plural) property changed from an array to a string scalar, and was renamed to `domain` (singular).
