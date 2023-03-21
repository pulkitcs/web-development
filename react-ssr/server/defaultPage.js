module.exports = function({container = "", head = ""} = {}) {
    return `
    <!DOCTYPE html>
    <html lang="en">
      <head>
        <title>Welcome to SSR application</title>
        <script defer="defer" src="js/bundle-client.js"></script>
        ${head}
      </head>
      <body>
        <main id="app">${container}</main>
    </body>
    </html>
    `
}