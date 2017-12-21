const runAll = require('npm-run-all');
const bs = require('browser-sync').create();
const debounce = require('lodash.debounce');

const runAllOptions = {
  stdin: process.stdin,
  stdout: process.stdout,
  stderr: process.stderr,
};

function generatePatternlab() {
  runAll(['build:patternlab'], runAllOptions)
  .then(() => {
    bs.reload();
  })
  .catch((err) => { throw new Error(err); });
}
generatePatternlab = debounce(generatePatternlab, 100);

function copyBuildFiles(pattern) {
  runAll(['build:patternlab:copy'], runAllOptions)
  .then(() => {
    bs.reload(pattern);
  })
  .catch((err) => { throw new Error(err); });
}
copyBuildFiles = debounce(copyBuildFiles, 100);

function startBrowserSync() {
  bs.init({
    watchOptions: {
      ignoreInitial: true,
    },
    // Watch and run tasks
    files: [{
      match: 'build/**/*.css',
      fn: () => copyBuildFiles('*.css'),
    },  {
      match: 'build/**/*.js',
      fn: () => copyBuildFiles('*.js'),
    }, {
      match: [
        'src/patterns/**/*.twig',
        'src/patterns/**/*.json',
        'src/patterns/**/*.md',
        'src/patterns/**/*.php',
      ],
      fn: generatePatternlab,
    }],
  });
}

startBrowserSync();
