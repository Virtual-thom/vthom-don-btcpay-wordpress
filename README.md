# Plugin Wordpress
Automatically add a donater when an invoice btcpay is settled, with a minimum amount. 
Or you can manage donaters manually.  
Display donaters list with the shortcode [vthom_don_shortcode_donaters]

# Get Started
Go to `wordpressdir`/wp-content/plugins

```
git clone https://github.com/Virtual-thom/vthom-don-btcpay-wordpress.git
```

Go to your admin wordpress backend and activate "Donaters" plugin.  
Add "Settings" (only twitter_api is not mandatory).  

From BTCPAY Server :  
STORE ID : your store Id.  
STORE URL : your BTCPay Server url.  
STORE SECRET : webhook secret in order to check BTCPay Sig [https://docs.btcpayserver.org/API/Greenfield/v1/#operation/Webhooks_UpdateWebhook](https://docs.btcpayserver.org/API/Greenfield/v1/#operation/Webhooks_UpdateWebhook)  
the btcpay webhook url you've created has to be : `yourwordpressurl`/wp-json/vthom/webhook-callback  
BTCPAY API KEY : your API KEY in account settings with minimum permission to view invoices `btcpay.store.canviewinvoices`  
MIN AMOUNT of Donation : example 20  
CURRENCY (for MIN AMOUNT) : exemple EUR  

TWITTER API : your Twitter API to get information if the donater begin with @  

Your code (btcpay button or whatever) must have a custom input in order to add an item description in invoices and add a donater name.  
Ex. `<input type="text" name="checkoutDesc" placeholder="Pseudo (optionnel)">`

full example of btcpay button for donation :  
```htlm
<form method="post" action="https://btcpay.virtual-thom.dynv6.net/api/v1/invoices"
  class="btcpay-form btcpay-form--inline"> <input type="hidden" name="storeId"
    value="F9DHb5TGfZWC4jCre2DgnWRsSpGesUoJiMc4UgMYASxW">
  <div class="btcpay-custom-container">
    <div class="btcpay-custom"> <input type="text" name="checkoutDesc" placeholder="Pseudo (optionnel)"> </div>
    <div class="btcpay-custom"> <button class="plus-minus" type="button"
        onclick="if (!window.__cfRLUnblockHandlers) return false; handlePlusMinus(event);return false" data-type="-"
        data-step="1" data-min="1" data-max="20">-</button> <input class="btcpay-input-price" type="number" name="price"
        min="1" max="20" step="1" value="1" data-price="1" style="width:3em"
        oninput="if (!window.__cfRLUnblockHandlers) return false; handlePriceInput(event);return false"> <button
        class="plus-minus" type="button"
        onclick="if (!window.__cfRLUnblockHandlers) return false; handlePlusMinus(event);return false" data-type="+"
        data-step="1" data-min="1" data-max="20">+</button> </div> <select name="currency">
      <option value="USD">USD</option>
      <option value="GBP">GBP</option>
      <option value="EUR" selected="">EUR</option>
      <option value="BTC">BTC</option>
    </select>
  </div> <input type="image" class="submit" name="submit" src="assets/images/BTCPay_Server_Icon.png" style="width:30px"
    alt="Pay with BTCPay Server, a Self-Hosted Bitcoin Payment Processor">
</form>
```
