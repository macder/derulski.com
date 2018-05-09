const path = require('path');
const ExtractTextPlugin = require('extract-text-webpack-plugin');
const CopyWebpackPlugin = require('copy-webpack-plugin');

// source root
const CONTEXT = path.resolve(process.cwd(), 'src');

// ui build root
const uiBuildPath = path.resolve(process.cwd(), 'build');

// pattern lab patterns source root
const patternsPath = path.resolve(CONTEXT, 'patterns/_patterns');
const layoutsPath = path.resolve(CONTEXT, 'patterns/_layouts');



module.exports = [{
  name: 'js',
  context: CONTEXT,
  entry: [
    'babel-polyfill', path.resolve(process.cwd(), 'src/scripts/main.js'),
  ],
  output: {
    filename: 'bundle.js',
    path: path.resolve(uiBuildPath, '')
  },
  module: {
    rules: [
      {
        test: /\.js$/,
        include: [
          path.resolve(process.cwd(), 'src'),
        ],
        exclude: /node_modules\/(?!(dom7|swiper)\/).*/,
        query: {
          plugins: ['transform-class-properties'],
          presets: [['es2015', {modules: false}]]
        },
        loader: 'babel-loader',
      },
    ],
  },
  plugins: [
    new CopyWebpackPlugin([
      { from: path.resolve(process.cwd(), 'src/images'), to: 'images' },
      { from: path.resolve(patternsPath, '**/*.twig'), to: uiBuildPath },
      { from: path.resolve(layoutsPath, '**/*.twig'), to: uiBuildPath },
    ]),
  ],
}, {
  name: 'css',
  context: CONTEXT,
  entry: path.resolve(process.cwd(), 'src/styles/main.scss'),
  output: {
    filename: 'style.css',
    path: path.resolve(uiBuildPath, '')
  },
  module: {
    rules: [
      {
        test: /\.(css|scss)$/,
        loader: ExtractTextPlugin.extract({
          fallback: 'style-loader',
          use: [
            'css-loader?-autoprefixer&importLoaders=1',
            'sass-loader?precision=10&outputStyle=compressed',
          ],
        }),
      },
      {
        test: /\.woff2?$|\.woff?$|\.ttf$|\.eot$|\.svg$|\.png$/,
        loader: 'file-loader',
      },
    ]
  },
  plugins: [
    new ExtractTextPlugin('style.css'),
  ]
}];
