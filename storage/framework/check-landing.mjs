export default async function run(page) {
    const stylesheets = await page.evaluate(() => [...document.styleSheets].map((sheet) => sheet.href));
    const hero = await page.evaluate(() => {
        const body = getComputedStyle(document.body);
        const heading = document.querySelector('h1');
        const headingStyle = getComputedStyle(heading);

        return {
            title: document.title,
            heading: heading.textContent.replace(/\s+/g, ' ').trim(),
            background: body.backgroundColor,
            fontFamily: headingStyle.fontFamily,
            fontSize: headingStyle.fontSize,
        };
    });

    await page.screenshot({
        path: 'storage/framework/landing-desktop.png',
        fullPage: false,
    });

    await page.locator('#collections').scrollIntoViewIfNeeded();
    await page.screenshot({
        path: 'storage/framework/landing-collections.png',
        fullPage: false,
    });

    await page.locator('#contact').scrollIntoViewIfNeeded();
    await page.screenshot({
        path: 'storage/framework/landing-contact.png',
        fullPage: false,
    });

    await page.setViewportSize({ width: 390, height: 844 });
    await page.locator('#main').scrollIntoViewIfNeeded();
    await page.screenshot({
        path: 'storage/framework/landing-mobile.png',
        fullPage: false,
    });

    const menu = page.locator('summary');
    await menu.click();
    const menuOpen = await page.locator('nav[aria-label="Mobile"]').isVisible();

    return { stylesheets, hero, menuOpen };
}
