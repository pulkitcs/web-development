const MiniCssExtractPlugin = require("mini-css-extract-plugin");
const ESLintPlugin = require("eslint-webpack-plugin");
const HTMLWebpackPlugin = require("html-webpack-plugin");
const path = require("path");

const devMode = process.env.NODE_ENV !== "production";

const config = {
  entry: "./src/index.jsx",
  mode: "development",
  devtool: devMode ? 'eval' : false,
  devServer: {
    port: 3000,
    watchContentBase: true,
    open: true,
    liveReload: true,
  },

  module: {
    rules: [
      {
        test: /\.(js|jsx)$/,
        include: /src/,
        exclude: /node_modules/,
        use: {
          loader: "babel-loader",
        },
      },
      {
        test: /\.(tsx|ts)$/,
        include: /src/,
        exclude: /node_modules/,
        use: {
          loader: "ts-loader",
        },
      },
      {
        test: /\.(css|less)$/,
        include: /src/,
        exclude: /node_modules/,
        use: [
          {
            loader: MiniCssExtractPlugin.loader,
          },
          {
            loader: "css-loader",
            options: {
              sourceMap: devMode,
              modules: {
                localIdentName: "[name]__[local]--[hash:base64:5]",
              },
            },
          },
          {
            loader: "less-loader",
            options: {
              sourceMap: devMode,
            }
          },
        ],
      },
      {
        test: /\.(png|gif|bmp|jpg|jpeg|ttf|otf|woff)/,
        type: 'asset/resource',
        exclude: /node_modules/,
      },
      {
        test: /\.svg/,
        type: 'asset/inline',
        exclude: /node_modules/,
      },
    ],
  },

  // optimization: {
  //   minimize: false
  // },

  output: {
    filename: "js/bundle-client.js",
    path: path.resolve("dist"),
    assetModuleFilename: 'assets/[hash][ext][query]',
  },

  plugins: [
    new ESLintPlugin(),
    new HTMLWebpackPlugin({ template: "./dev-template/index.html" }),
    new MiniCssExtractPlugin({
      filename: "css/[name].css",
      chunkFilename: "css/[id].css",
    }),
    // new statWriter(),
  ],
};

// es5 implementation of a class
function statWriter() {};
statWriter.prototype.apply = function(compiler) {
  compiler.hooks.done.tap('compiler is done', (stats) => {
    // Custom plugin
    //console.log(stats.compilation.assets);
  })
}

module.exports = config;