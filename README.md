# Card battle game

is a programming exercise repo. With applied event sourcing using [prooph library](http://getprooph.org/) and [behat](http://behat.org) for BDD approach.

# Install

Build container:

```
docker-compose up
```

Enter into container:

```
docker exec -it card-battle-game bash
```

Run functional tests:

```
vendor/bin/behat
```
