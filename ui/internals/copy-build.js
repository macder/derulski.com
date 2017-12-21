// this is going to copy assets into pattern lab internal build

const copy = require('copy');
const chalk = require('chalk');
const path = require('path');

const rootDir = process.cwd();
const publicRootPath = path.resolve('..', 'public');


const handleDone = (err) => {
  if (err) console.log(chalk.bold.red('internals/copy-build Error: ') + chalk.red(err.message));
};


const src = path.resolve(rootDir, 'build');
const dest = path.resolve(rootDir, 'pattern-lab/public/build');

copy(`${rootDir}/src/images/**/*.*`, `${dest}/images`, handleDone);
copy(`${src}/*.{js,css,svg,woff,woff2,eot}`, dest, handleDone);
