<?php

declare(strict_types=1);

// @phpcs:disable PSR1.Methods.CamelCapsMethodName.NotCamelCaps

namespace Arokettu\Encryptor\Tests;

trait TestData
{
    /**
     * @param string $content
     * @return resource
     */
    protected function getTempStream(string $content = '')
    {
        $stream = fopen('php://temp', 'r+');
        fwrite($stream, $content);
        rewind($stream);

        return $stream;
    }

    /**
     * @param resource $stream
     * @return string
     */
    protected function readTempStream($stream): string
    {
        rewind($stream);

        return stream_get_contents($stream);
    }

    protected function getPassword(): string
    {
        return '123456';
    }

    protected function getDecrypted(): string
    {
        return <<<MD
The MIT License (MIT)
=====================

Copyright © 2019 Anton Smirnov

Permission is hereby granted, free of charge, to any person
obtaining a copy of this software and associated documentation
files (the “Software”), to deal in the Software without
restriction, including without limitation the rights to use,
copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the
Software is furnished to do so, subject to the following
conditions:

The above copyright notice and this permission notice shall be
included in all copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED “AS IS”, WITHOUT WARRANTY OF ANY KIND,
EXPRESS OR IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES
OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND
NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT
HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
FROM, OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR
OTHER DEALINGS IN THE SOFTWARE.

MD;
    }

    protected function getKey_V1(): string
    {
        return 'debb383cc375b4aa3934eeb4fbec868daa2ebbe29996f93d7dd57f67b3d914f3';
    }

    protected function getEncrypted_V1(): string
    {
        $data = <<<DATA
ZDI6X2E1OnNmZW5jMjpfdmkxZTU6bm9uY2UyNDpVdNnzMhylB72Ox+AcF/teSkZIOh1EMwA3OnBh
eWxvYWQxMTI1OphQ1l6n4djHHlbVM9gL/ngRJax6l6bANzWH6PJxRfU8O9xvUUyrk4d/pO7ZoV/x
k7xMgk39lsbcCgUCQ+2lxYu8wZ34XMd/Kd9Ub7PU27Cxw2aU12lV2WCVR2mdV3JbrJjmQqYTLMjt
w9GFPycxqBkJxLpRKs7MKrKOyM6DxzkvcX6xTHgnLuqCiDClxXPnsQo8bdCJnmKmvWnFtm2+LamX
0+vK553fDwt+Wux02f9tWAiRZBWeec13zKN0q6Z588NrjClJeb0fa763Hv3uNhn4JsIQRJTBMkS/
ixNBGMM+DCrd1krYYjCB5v4VUN0CKjWxMX0TSqkA9hNG/A2ZE0Ks0LP9WJJzxXiGMtdyatG4VU3b
XFC7OrwpmlwRJKUm2LFMXBnGvCGMQJwQlbJBNnnSwUicBIF4xF+I/X5PFXLG+D3m0wYJJHwpaZlf
dLkNd3ZeXZ9JR3DaI6u9dHBMgg+j+CSREJB7e4iNrrMP6dgy03tK2Sec2rzDCvKdMIVdC3M4/A6c
FhBXvf/S6fQ1lLd6TqL8kplbtYOLZq4qeVevd1aPlA2nIwPxJDcJG+Oz3lovrxH1QsyNkeSbLtcJ
Kmhj8UhaHmGa6I3SAWq/czLoAJiCCrlqOYTf5PwhW0dfGo6eyYq13NWV6w2bjJEQbmQjyFSlulth
ei18bbBgWZ/kmXQZbtcQ6DPQ8Go0BRdnXT6sQS6zHdw8+uetpo/CFYZw//0KVHtCt33Coj7dReDA
+CJiQu5vc/itquZlgrlldhkOreyu7p0i57vtLAObbglMaR3MwIgyAlIfGVrDwGQPqi5KkP4NKe6F
sxQVC/KCAwFNly35In6ySt/1dr+524qrteGoSrAfoaZ7K4zVduzZafiZ0Yb9lV1kodY++0B0wm88
P1foGfl29N1jk/ssLbbNImaVdgIyS8mRMNVaw+vlZd0W065SoYJSALnLgDM3k7fF2XnyXdW9nQHq
g7OCHk/wJhPaV1Ezu+174xCtaj2sdGKKPZ+U8kq796ykw60jIpQbOl64bRxC4/Eq44B57fVQ4L5L
x++2KnXH8w2Rc7Fk6If/XM9DOR+k/1xhewzeco8frlWIx92q4QqtNFbLHwBz6MJr80BZ58zdU60O
+NzuosAJJLTyEJXEdl8yd8LL90Eb4rzlU+nDXOdFCNr+C4Cr2xJ/Wh1QzMxcJZweAFJXVAT6XcLK
mEBrxiDsMVcie5136XcHrKJxUeZJYZrYuNWqseuijZyBlrv9BI9Wlcus0461BTOZI0NYPjN3uvdi
DbOwGodXqoRAG598Yp1LUO5xaqVp3yK/pLJrLEQbjjDcPAfcpV+mygLUPXv+ZPoR/DZlLn/0auZZ
ioAnqjH4JIgjL+DTRRv4MjnqNdxR0vJqDldYZKIrE75vH7k55sIECrZKH03xngtQB2YxICRxedEx
arj/2654JaZgXI1W76oawZ6CQ8sHQV5rutMJaU1jiQ5lGOpbPJ58nAs5zRXPYDQNXY0i+DQ6c2Fs
dDE2Ohv6RkonmyJhWydU8d+M9yBl
DATA;
        return base64_decode($data);
    }

    protected function getKey_V2_S1(): string
    {
        return '71e00886bbcd566b83d8e2dd8e010b952c9719bfdc7bf671cd45fb52d2b6ac2c';
    }

    protected function getEncrypted_V2_S1(): string
    {
        $data = <<<DATA
ZDI6X2E1OnNmZW5jMjpfdmkyZTM6bWVtaTY3MTA4ODY0ZTU6bm9uY2UyNDp+VySixD5vYkNbckLq
7qYCXJV8cL8crmYzOm9wc2kyZTc6cGF5bG9hZDExMjU6++nMWyt7WH0Nmb5tcyd8r5fo7W7obe63
0OuGz0Qs0zxV14RHwc7QcCCqiUD5jvpC+K4fLom2TQ0xQjG7YShTcPbyVKMPh1HKHisHhErw6mva
EjuLrkCVPrBILCCUnHS3skoWBt9H4Fsz7+ipE/8S8ZMMQgsYIffgGoNZPup+poW52m1AS3nQoxBa
hOM9BYfMzXb64dLcnXSHuRL11vonx8HAtvrYsoCTmsFdEOZn3+riXLtSdA4GIyBizyv5umKE77tJ
q20WFSW2fLX1iqGLDZBDsclvdN4Chm0CF7uPSjLZJO/kamp5HKfDCPPOFGzZC3wxRQOoBA8KIrmi
bGQ/bO4OIHFamKqWWlb0jNAyoPmtuEX3yp3Qy+O7w6Ri9mFuC1CaUJxq/3QgrUa0dW2DUvACp9Z2
zwieIPqUdggA61wtuspOEmHTzUXkjIhWGMnXsfjELLBF+S6cYte2YkzhcRqfMBSzMAK4xdbVfgwi
QR/z4YKDYWmI9QkwY/kc9Xmifi/e6CxlSyOcfuojF6nsecJMBzVUD8DVQE7ECdrROUCf/MpZ9ZpJ
5TCeyQ0PqPpQD2Oxgdbrz/F9BoEpnnt1x4BdOA5dU/7P/EgcVqcpojSzoyqSpQFxmazlcowjS8eG
HfyjwB+NmVN2qhtONWIGY8yunRKZQP4jubo6XYokZD28XhW3e4cd1FiZS1IxNcVEAs9/kuIDxnN+
lKlnp2vIDVLCjiyLlXAZu5283bqflQqExDHyCKkZcKJjhl8Rf6HnawHosdFkH/p5BduYaRpTr91W
fWFpq6eTjRHih0wIftN/oaymTI7zskgZ3BwBn5KruXLRcFFdAt5n5BsYOgU5N5HMzfx7FHSDx14E
ujbvzbeGpSA9z6LbVTsUx/6B1lVnNrzSjex9MdmCAH9beU19K5E+tq96H2i5J6cbkhvt3dx3lOmM
l6In7CeyJVArXrgeLYhVSiLkfsqmXyrpxb7eoDzR2OKNSb0lI2ceL2vHdpQ4miMAwrvpMIAMmH8J
9F9Ff1MNZTx/KyvriuF0MZ0mz/IEfZReotF5gXNSZbtHW3V+yZzMoV7x5zlA8TZSaNuIXBRS5G76
VJTUqnhfJjgwxNPVoDUWpKdoGxPYiGDbF2xzs1NmuWS6ShfKAMMUtGdvhQ+QWs6Jf8p3mwAjhTrB
LgKV/hEKvZw6Cmp35FMEnkEuc4C4i/R90EHSDgWHDwfzh5PYBWl/WeNJcLE1SDKPU8Frnlooqppv
youHzAUNFY0+PTZAq/bpBRUitB4+EN3ALZNDqGCSqMnbibLCROdAm++Fnz62zaWLEd+QX3886675
xgyZctV0hhOl88CzQFF7tpDgXvoC0hB5o2JX0YIEqzPM2BV6uKzpGTYJf/DiIZ7g271fZkCkIsTz
iWjDTZE5UnfFY4XY9oiuYCFa2U8J7ByFGOK7ffl5BZigz/5FknPej5IrXsUxOlzeghoB5R56fBt2
cIs+XFTRegAnJrt4OPGtmdRTNDpzYWx0MTY695XczqXk7jsI/SP7ljnrJ2U=
DATA;

        return base64_decode($data);
    }

    protected function getKey_V2_S2(): string
    {
        return 'e2ca8b8f971148b59e3f66ae2420d664b12a9a824e791df2bb75320b4cc7237c';
    }

    protected function getEncrypted_V2_S2(): string
    {
        $data = <<<DATA
ZDI6X2E1OnNmZW5jMjpfdmkyZTM6bWVtaTI2ODQzNTQ1NmU1Om5vbmNlMjQ6AHyB6buAQSArZPz4
uV2S/YZGK5jlbCk0MzpvcHNpM2U3OnBheWxvYWQxMTI1Ohy5qH9XUxVnB6y6+nu6Fr5bWLKpa6CK
GN10RzN0yQIdRCyLKpLazGI63THzxaSK1NixDcJN2ItXEXlF+vMlI/l9rq5BAsPN1w36q6EsrMtq
yKkrogzvx9cKHWdKp9VHnK+zzCmBQJLyyBtz0XdxHMqWNBsAgcEFyinA6gKY57jfdhx1MUhA6FGd
eLf0HmKKm/FcBEg+ymYIeumlN5oJ0iHMAX6sWiXElC05FrT4Ea1I76mkIPf6ksGTdPX1XkiRkVTS
MqULb+ZAQWai7zqAksaz8L/ms0ZDsOY5cgFyj9iKe6FDrfUvnNKIOVD1Sdsq7iGMpR46kxrNtRaf
BBby92OHb6aFHV/wLLXLiE/JsNYElS5014P2dndnOLKST1+qcP7CdJWULoMnCsI0egFXAL2BDVu7
7Po44xatnwOWWrGq9iAmenLihZjcwLffTgnARYYqu/ClCsyYuWWsoDpMGtl4pWXxdaj19KHIXjUp
T6OwQ9JoiGZtdRNxLExqveMP6hPMGOLzuqHf54X0rSSUGoLKUoT3eUNw45zNP6BMMct9ZzBVAi+t
jXOQwbVi1g0RVY6ousUlp3kyQQySIvDqEclc06yaciryUtD0MBnVGsXqWbI42jjqWG5WiplwWESe
KFqoRN1+lYsKVXqulUCzBp82X6QteGsIPU1x5AqL97v0eU5v1okjPzbI10BGOGvn0nYyI8MF2Zf+
ibcEzOe+e9eCrK6rksVEGRo/LrqB7WpEFIeIA+9Aanh5LOcn7oTOVg7thXWJ0qKdFtFMzIjFXDeR
qimH83ii/KK9FuGl1nxcXAT2SLw+PftEOpQHkNn3slALswg2GGHjL3AY/laWswlq+IogVDOoc72C
imSTduDzFH9yD15gdIAmewX4rrzDYiZ9+OfP0tL4+7lGA0FKV7vyMt5342zU20OHctEb1D0dTjor
iFBiLGNMnTHHQVwzL5ELh3F20MY2L/Um4j9SVgr993Z1lkMU86+Jd36sBczP96xwOTv0maS3k9ic
H7r7MEIkPIE2ov/l2XGF+bS9sJt5L3c4UqXU1oJLsomjLvvdHBKzZTOcpvrJkySNIJd8lF2Frews
92vukFK6MbV4pr1ZQoeBda0MLvSNQgqDt/je7wBTBAEEv2Xpwj8RscCmcZ26vgM7lz4yg08dZSMq
1kGSGIghobnlPI9nr/G3sU9hCKCAMCBk/ssoc3YKw5P7IwVxHp3e0cnzwORzLRCUvXZl1FkgBhsg
czJCuGKhlIW72x5+RCWMshpRPXrpGJGF8ToDJXPzYhZFiIwTH3DlbpeJ3coRWixpDs3qYjhb5mIs
ffFq3n8AJ82w8rGuFHtYV1fqaLmYHMMWBRAn3ucJ9hCi+PtluWCdGglkfkm91lZ6onqa+PqYWl7m
g+W8evmnFMxFyUeFNuQTbOL+MV2URomV8tpESGmaen8kXH+A/62vw6EQN89S/6rcUmL6JjomOW5m
am8D+uKaifgGurCM2+jNpQ3I6jQ6c2FsdDE2Oq2eDe1Ek9wsJHiGc34OSodl
DATA;

        return base64_decode($data);
    }

    protected function getKey_V2_S3(): string
    {
        return '1ace37716a1dca026291ed0b856abf4bb20d4808c7e66d91ce6ecd675dee2c36';
    }

    protected function getEncrypted_V2_S3(): string
    {
        $data = <<<DATA
ZDI6X2E1OnNmZW5jMjpfdmkyZTM6bWVtaTEwNzM3NDE4MjRlNTpub25jZTI0OnzS1RaBAtUriana
dBLcc68ffmoGQY2lkzM6b3BzaTRlNzpwYXlsb2FkMTEyNTrR4hSjiJd0eR3tLdHdRu8WrB11yBEV
V26egabc7a82rEOwyIAog0K7TlCeSVW4lTNqClvmaT52fmo4dkTwvN0SlMoWUFVnwxhFkI71AF/N
skYwvuv72MZWHcq40cPMGuG3HSow7/+ycE0EmyzVE2OFDPyCFwI+Tachp9ayE/Nytx57JDyczR5L
BpP07B2L4flJqYU5gfTIQ3cw+nRAVEHjqk4qS8kB+Lsc67tTz5VjSZRUYA/5/C11zdOmMcRfVkmT
VaWo1mDJTEbGIZKnBuyb8bJg3xo2+pNnRn0M91RHFw5PYCoiwjipGKMLxZn9S1b97iHC2i7WDeCw
XHgXHAF/J+EN5tBNig+q2YVCwVAaUvWSDtPc8R4rYAwP51T+mCPVNhUsVOXxqJPEupqTOvEaM8+Y
X4MnpKDQEj9jKSILrj4x3sxw5RE4ZEOPPNm5bQHmqT2NxDNFWJ948WfT7AmmtOQLD2HE6iJpjg3b
iVyF8bYjoaW4j8LwFWioegwwbwM+nUjuHcTekbTafg5ZOTCUZ7hZp70HvR7Whfc69mJmGGkPkSsA
h1HQ7Q0ZW5ZGBnTMLKCVW0i7F/iHEDQjWfDnA31Iqz1cqtrWWfnS8R2gEi+OLzGQkunuhfhmSxzh
aqPldbZpHkjtDPPFHsPbF3tI73C1U9x3fcr3x2nmG4ed5D9s1EnwkNGl+aI8hSmb8g6TFLMneVF7
C3Brd12IATpB0pGX5KVcTjm2twfJa0BJRQmOLylXs38xEzVKG17ifNkhxD1Cb2F4a27+wwyeBuPz
FGr8wPEZrn/3LlLoLqrJph9J4UquqUI3rB9Ofdp2iZClYRU/FbpXJq7sU7fgv09d51pBaRo5fFis
kK1busV8JTbZFyNHVj8DiQwsV010XlIfBGgw97sgsYL2sdXZl5JMd7mELV6age/VzSZ+sAFD/V9I
hc9iW5YqodDl2fq90UmtaUNyYMGy/XzEJOZXDRkkNOJ569MDGfwZsLU8aRRgQs3+sOc+zkiff+77
lwCm6f+jnahK/g4rBajBNiMmykX6uenQz9j07qC4qD8KX007aMHfh92GB5NnAmoRH2KGgUaGV2er
QaZp7/Bu74sk/VcW5587Pt+2g1UENm2aRB9poLM+8qaWQ4aKoMdQACWYmRmUSwdmKMlMntzL/dnb
FXErxfR/oCQsP5s4GF5Dg1MwUNw67CgRpRe7a63M3U5Nfdo2zp27VJimSwAkZyWjnTGdPxCNmQOv
L/I2H5kLYhl+txTtySw16E8x217/vLbUTFg8hDzLz0voVkzjUV/fh+BmOeecCnOOTv+zRUIYD9YZ
lGqtudUTrfRyjrFDJuY/iL6Am3pvSZJuZRSmELGFd6UfKk82EBZyRuyXhcjTGWy4URHiK3AjF3Hc
nGaHUVpG63R7Bq2cCXoV4z3ac3beSRSSrTkeN9qcHY29g4aHvx6Hh6uqZRpRyVy1Ywfw9dJ6BMn3
ndDEXq357tGnuHMBshaWBpWCy+U0OnNhbHQxNjoPFIuQLyz5lRL8X4jSuXTFZQ==
DATA;

        return base64_decode($data);
    }
}
