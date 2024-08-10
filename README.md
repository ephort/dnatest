# Beyond the Tick-Tock: Exploring Timing Attack Techniques

This is a demo application for the talk "Beyond the Tick-Tock: Exploring Timing Attack Techniques".

## Up and running

```
sail up -d
rm -f storage/invoices/* && sail artisan migrate:fresh --seed --force
```

 - Make sure the connection is served via HTTP/2
 - Create test order for another person
 - Create test order for yourself on dnatest-au
