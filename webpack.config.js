const webpack = require('webpack');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const globImporter = require('node-sass-glob-importer');
const path = require('path');

module.exports = [
  // js build
  {
    entry: {
      application: './assets/js/application.js'
    },
    output: {
      path: path.resolve(__dirname, 'html/wp-content/themes/start-media/js'),
      filename: '[name].js'
    },
    module: {
      rules: [
        {
          test: /\.js$/,
          use: [
            {
              loader: 'babel-loader',
              // Babel のオプションを指定する
              options: {
                presets: [
                  // プリセットを指定することで、ES2018 を ES5 に変換
                  '@babel/preset-env',
                ]
              }
            }
          ],
          exclude: /node_modules\/(?!(dom7|ssr-window|swiper)\/).*/,
        }
      ]
    },
    plugins: [
      new webpack.ProvidePlugin({
        $: 'jquery',
        jQuery: 'jquery'
      })
    ]
  },
  // css build
  {
    entry: {
      style: './assets/sass/style.scss'
    },
    output: {
      path: path.resolve(__dirname, 'html/wp-content/themes/start-media'),
      filename: '[name].css'
    },
    module: {
      rules: [
        {
          test: /\.scss$/,
          use: ExtractTextPlugin.extract({
            fallback: 'style-loader',
            use: [
              {
                loader: 'css-loader',
                options: {
                  url: false,
                  minimize: true
                }
              },
              {
                loader: 'postcss-loader',
                options: {
                  plugins: [
                    require('autoprefixer')({grid: true})
                  ]
                }
              },
              {
                loader: 'sass-loader',
                options: {
                  importer: globImporter()
                }
              }
            ]
          })
        }
      ]
    },
    plugins: [
      new ExtractTextPlugin('style.css')
    ]
  }
]
