const puppeteer = require('puppeteer');

(async () => {
  // set headless: false to open chrome browser 
  const browser = await puppeteer.launch({headless: false});
  const page = await browser.newPage();
  await page.goto('https://dev.crluo.com/login');
  // test display size
  await page.setViewport({
    width: 768,
    height: 900
  });

  console.log('run on viewport 768x900')

  // wait for loading page 1s
  await page.waitFor(1000);
  console.log('wait for loading page 1s')

  // take screen shot
  await page.screenshot({path: 'puppeteer/img/example-crluo-viewport.png'});
  console.log('take screen shot on viewport 768x900')
  // display size 1366 x 768
  await page.setViewport({
    width: 1366,
    height: 768
  });
  console.log('run on viewport 1366x768')

  // find email and password input tag
  const emailInput = await page.$('#email');
  const passInput = await page.$('#password');
  // type email and password to login
  console.log('type email and password to login');
  await emailInput.type('admin@gyaku.info', {delay: 100});
  await passInput.type('aaaaaa', {delay: 100});
  // take screen shot after type email and password
  await page.screenshot({path: 'puppeteer/img/example-crluo-login-input.png'});
  console.log('take screen shot after type email and password');
  // press enter on keyboard
  await passInput.press('Enter');
  // wait for navigation
  await page.waitForNavigation();
  // take screen shot after login
  await page.screenshot({path: 'puppeteer/img/example-crluo-login-success.png'});
  console.log('take screen shot after login');
  console.log('Success!!!!');
  await browser.close();
})();
