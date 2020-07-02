const puppeteer = require('puppeteer');
const fs = require('fs');
const cheerio = require('cheerio');

(async () => {
  const browser = await puppeteer.launch()
  const page = await browser.newPage()
  await page.goto('https://www.funko.com/shop?filter:productType=pop!')

  const content = await page.content()
  const $ = cheerio.load(content)

  const lastPage = $('.pagination button.white').last().text()

  const items = await scrapeItems(page, lastPage)

  fs.writeFile('data/data.json', JSON.stringify(items), (err) => {
    if (err) {
      throw err
    }
  })

  await browser.close()
})()

async function scrapeItems(page, lastPage) {
  let items = []

  try {
    let currentPage = 1

    while (currentPage <= lastPage) {
      currentPage += 1

      const item = await page.$$eval('.commerce-products-list-item .title strong', as => as.map((a) => {
        return {
          name: a.innerText
        }
      }))
  
      items.push(item)

      await page.click('.pagination .pageControl.next')
      await page.waitFor(1000)
    }
  } catch (err) {
    throw err
  }

  return items
}
