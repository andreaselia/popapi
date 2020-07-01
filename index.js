const puppeteer = require('puppeteer');
const fs = require('fs');
const cheerio = require('cheerio');

const url = 'https://funko.com/collections/pop-vinyl';
const collections = [
  'animation',
  'disney',
  'games',
  'heroes',
  'marvel',
  'monster-high',
  'movies',
  'pets',
  'rocks',
  'sports',
  'star-wars',
  'television',
  'the-vault',
  'the-vote',
  'ufc',
];

(async () => {
  const browser = await puppeteer.launch({
    args: ['--proxy-server=socks5://127.0.0.1:9050']
  })
  const page = await browser.newPage()
  await page.goto('https://workoutlabs.com/exercise-guide/')

  const content = await page.content()
  const $ = cheerio.load(content)

  const items = await scrapeItems(page)

  let i = 0

  for (let i = 0; i < items.length; i++) {
    var item = items[i]

    await page.goto(item.url)

    const data = await page.evaluate(async () => {
      var title = $('h1.exTtl').text()
      var content = $('.cntWrp li').map((i, el) => el.innerText).get()

      var metas = {
        equipment: $('.metaWrp .metaBlock.i1 .metaVal a').map((i, el) => el.innerText).get(),
        primary: $('.metaWrp .metaBlock.i2 .metaVal a').map((i, el) => el.innerText).get(),
        secondary: $('.metaWrp .metaBlock.i3 .metaVal a').map((i, el) => el.innerText).get()
      }

      var image = $('.cntArea .imgWrp img').attr('src')

      return {
        title: title,
        content: content,
        metas: metas,
        image: image
      }
    })

    data.url = page.url()

    const image = await page.goto(data.image)
    const imageContent = await page.content()

    fs.writeFile(`exercises/${i}.svg`, imageContent, (err) => {
      if (err) {
        throw err
      }
    })

    fs.writeFile(`exercises/${i}.json`, JSON.stringify(data), (err) => {
      if (err) {
        throw err
      }
    })
  }

  await browser.close()
})()

async function scrapeItems(page) {
  let items = []

  try {
    let previousHeight

    while (items.length < 50) {
      items = await page.$$eval('.neGrid > a.exWrp', as => as.map((a) => {
        return {
          url: a.href,
          text: a.innerText
        }
      }))

      previousHeight = await page.evaluate('document.body.scrollHeight')

      await page.evaluate('window.scrollTo(0, document.body.scrollHeight)')
      await page.waitForFunction(`document.body.scrollHeight > ${previousHeight}`)
      await page.waitFor(1000)
    }
  } catch (err) {
    throw err
  }

  return items
}
