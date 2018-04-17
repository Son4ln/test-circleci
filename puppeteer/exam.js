const puppeteer = require('puppeteer');

(async () => {
  // set headless: false to open chrome browser 
  const browser = await puppeteer.launch();
  const page = await browser.newPage();
  await page.goto('https://dev.crluo.com/login');
  // test display size
  await page.setViewport({
    width: 768,
    height: 900
  });

  // wait for loading page 1s
  await page.waitFor(1000);

  // take screen shot
  await page.screenshot({path: 'img/example-crluo-viewport.png'});

  // display size 1366 x 768
  await page.setViewport({
    width: 1366,
    height: 768
  });

  // find email and password input tag
  const emailInput = await page.$('#email');
  const passInput = await page.$('#password');
  // type email and password to login
  await emailInput.type('admin@gyaku.info', {delay: 100});
  await passInput.type('aaaaaa', {delay: 100});
  // take screen shot after type email and password
  await page.screenshot({path: 'img/example-crluo-login-input.png'});
  // press enter on keyboard
  await passInput.press('Enter');
  // wait for navigation
  await page.waitForNavigation();
  // take screen shot after login
  await page.screenshot({path: 'img/example-crluo-login-success.png'});
  await browser.close();
})();
