# Defence against the Dark Arts: Detecting and Mitigating Timing Attacks

This is a demo application for the talk "Defence against the Dark Arts: Detecting and Mitigating Timing Attacks".

## Up and running

php artisan migrate:fresh --force && php artisan db:seed --force && rm -f storage/invoices/*
Make sure the connection is served via HTTP/2
Create test order for another person
Create test order for yourself on dnatest-au

## Talk manuscript

 - I have been intrigued by timing attacks since I attended a Ruby on Rails meetup in 2019 where a guy named Rune Philosof 
showed how timing attacks could be used to reveal a password string one character at a time.

The vulnerabilities Meltdown and Spectre that was huge disasters in 2017 also used timing attacks to reveal memory contents.
These vulnerabilities caused the chip industry to redesign their CPUs, and almost all computers in the world at that 
time was vulnerable.
I remember servers at the host Digital Ocean that was provisioned prior 2017 that was suddenly performing very badly after
the patches were applied, and the only way to fix it was to order a new server.

So it's safe to say that these vulnerabilities had a huge impact.

As web-developer I naturally wanted to find out how web application could be exploited by this, and dug a bit into it
but most information I could find showed that even though timing attacks very theoretically possible, it was very
impractical to exploit in real life.
Most talks and papers on the subject was using very large datasets and doing some hard statistical analysis exploit it.
And it also turned out they controlled the infrastructure very tightly, and could control the network latency and throttling
of the servers.

But then I stumbled upon something called Timeless Timing Attacks that would not be affected by network jitter and latency,
and would reveal timing differences in remote calls with a very small sample size.

Then it suddenly became practical, and in my opinion a very real threat that forces us to write code in a different way
than we are used to.

So I hope this talk will inspire some of you to think this into the way you write code in the future.

 - Let me explain what timing attacks are

A server takes some time to execute the code. Is the code doing a lot of computation, disk I/O or network access
it will take longer time to execute than if it's just doing some simple calculations.

If the user input is used to control the execution flow of the code, the user will be able to obtain information 
that was not meant to be revealed to the user.

That is a timing attack.

 - Let's look at an example (order form)

I have made a website for today called Dnatest.test.
[Show around on the website]

The site is written in Laravel and uses a MySQL database.

The site is a simple DNA test site where you can get a report on your ancestry.

[Make an order, and show PDF invoice with network tab open]

What happened?

Let's look at the code

 - How to prevent?
A: Generate invoice on order saving

This is a very simple example, but it shows how timing attacks can be used to reveal information that was not meant to be
revealed.

 - Let's look at another example (result form)

If I type wrong username and password, I get error message.
If I type right username, but wrong password, I get same error message.

This is for security reasons, so the user can't guess usernames by looking at the error message.

And if I type the correct username and the correct password I get the result back from the DNA test.

Let's try with my brothers phone number, and see what the result is.
The execution time is slow, which points to the fact that he has indeed ordered a DNA test.

But I don't know his password.

Luckily there have been a lot of breaches where usernames and passwords have been leaked. Haveibeenpwed.com is a website
where you can check if you have been part of a breach.
But the leaked passwords are quite accessible on the internet, so a hacker would try that first thing.

bash query.sh kristian@ephort.dk <-- current work email
bash query.sh kristian@justiversen.dk <-- his private mail

And we are now behind enemy's lines.

 - Local / remote

Now we have just been looking at my local machine, but remote there is a lot of network latency and jitter that can
affect the timing of the requests a lot.

To test this I have deployed a server in Sydney in Australia - that should be the opposite side of the world.
Let's take a look at dnatest-au.dk .

It's awful slow - so what do we do? 
We can either move to Australia or we can use The Dark Arts - also called Timeless Timing Attacks.

 - Timeless Timing Attacks

A researcher named Tom Van Goethem and some others have found a way to do timing attacks that is not affected by network jitter and latency.

They call it Timeless Timing Attacks.

Instead of looking at the wall clock and measure how long time something takes as we have done so far, they take advantage
of the HTTP/2 protocol, that has a feature called Multiplexing.

Multiplexing allows the client to send multiple HTTP requests to the server in the same network connection, and the server
will then return the responses in any order. Whichever is ready first.

This means that the client can look at which order the requests that was sent to the server was returned in, and use that
to determine if the server took longer time to process the request.

The recipe for Timeless Timing Attack is to 
 1) Send pair of requests to the server - in each pair a request with valid username, but incorrect password and a request with a username to test and incorrect password 
 2) Send a number of these request-pairs to the server depending on the response time of the server. I have chosen 6 requests.
 3) If the request with the valid username and incorrect password is returned last in all the request pairs, then it indicates
that the username we are testing does not exist. If they are returned at the same time, then the username exists.

 - Let's try it out

python3 ./timingattack/dnatest.py

[edit dantest.py to try with unknown username]
[edit dantest.py to try with guessed username]

 - How to prevent?

Since Laravel 8 the Timebox support class is available.
It's a class that can be used to make sure that a request takes a minimum amount of time to process.

 - Detecting vulnerabilities

Identify sensitive information (vary between applications).
Remember that most vulnerabilities are chained when exploited - so could be a stepping stone in a chained exploit.
Remember that information is given away in multiple ways (what we say, what we don't say, how long we take before we say it etc.)

Mitigating is possible by hiding the execution time from the user.
We can do that by:

1) Using Timebox
2) Pushing to async queue
3) Use cron jobs
4) Send email with sensitive information on demand instead of showing it in the browser

 - Conclusion

Timing attacks are a real threat, and we need to take them seriously.
We need to think about how we write code, and how we can prevent timing attacks.

 - Questions
