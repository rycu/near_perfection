
///////////// CONFIG /////////////

var gulp = require('gulp'),

	bless = require('gulp-bless'),
	bower = require('gulp-bower'),
	concat = require('gulp-concat'),
	livereload = require('gulp-livereload'),
	plumber = require('gulp-plumber'),
	sass = require('gulp-sass'),		
	size = require('gulp-size'),
	sourcemaps = require('gulp-sourcemaps'),
	svgmin = require('gulp-svgmin'),
	uglify = require('gulp-uglify');
	

var config = {
	bowerDir: 'bower_components' ,
	rawjsDir: 'raw_js',
	rawsvgDir: 'raw_svg',
	imageDir: 'img',
	fontDir: 'fonts',
	jsExportFile: 'script',
     sassMainFile: 'style'
}

var scriptList = [	
	config.bowerDir+'/jquery/dist/jquery.min.js',
	config.rawjsDir+'/*.js'
];

/////////// CONFIG END //////////


///////// IRREGULAR TASKS ////////

/* ---- bower update ---- */
gulp.task('bowerUpdate', function() {
  return bower({ cmd: 'update'});
});

/* ---- move font-awesome fonts   ---- */
gulp.task('moveFonts', function() { 
    return gulp.src(config.bowerDir + '/font-awesome/fonts/**.*') 
        .pipe(gulp.dest(config.fontDir+'/')); 
});

/* ---- file size report ---- */
gulp.task('sizeReport', function() {
    	 gulp.src([ config.jsExportFile+'.js', config.sassMainFile+'.css' ])
        .pipe(size({showFiles : true}));
});

/////// IRREGULAR TASKS END //////


/////// PRE DEPLOYMENT TASKS //////

/* ---- min scripts ---- */
gulp.task('minJs', function() {
	gulp.src(config.jsExportFile+'.js')
	.pipe(plumber())
	.pipe(uglify())
	.pipe(gulp.dest(''))
});

gulp.task('bless', function() {
    gulp.src(config.sassMainFile+'.css')
    .pipe(bless())
    .pipe(gulp.dest('css/'));
});

gulp.task('preDeploy', ['minJs', 'bless']);

///// PRE DEPLOYMENT TASKS END ////


//////////// LIVE TASKS ///////////

/* ---- concat js ---- */
gulp.task('scripts', function() {
	gulp.src(scriptList)
	.pipe(plumber())
 	.pipe(concat(config.jsExportFile+'.js'))
	.pipe(gulp.dest(''))
	.pipe(livereload());
});

/* ---- compile sass ---- */ 
gulp.task('sass', function() {
	 gulp.src('sass/'+config.sassMainFile+'.scss')
	.pipe(plumber())
	.pipe(sourcemaps.init())
    .pipe(sass({outputStyle: 'compressed'}).on('error', sass.logError))
    .pipe(sourcemaps.write('maps'))
    .pipe(gulp.dest(''))
    .pipe(livereload());
});

/* ---- svgmin ---- */
gulp.task('svgmin', function() {
	gulp.src([ config.rawsvgDir+'/*.svg' ])
	//.pipe(plumber())
	.pipe(svgmin({
		plugins: [{
                cleanupIDs: false
            },
            {
                removeUnknownsAndDefaults: false
            },
            {
                collapseGroups: false
            }]
		}))
	.pipe(gulp.dest(config.imageDir+'/'))
	.pipe(livereload());
});

/* ---- watch  ---- */
gulp.task('watch', function() {
	livereload.listen();
	gulp.watch(config.rawjsDir+'/*.js', ['scripts']);
	gulp.watch('sass/**/*.scss', ['sass']);
	gulp.watch('**/*.php').on('change', function(file) {
          livereload.changed(file.path);
    });
    gulp.watch( config.rawsvgDir+'/*.svg', ['svgmin']);
});

////////// LIVE TASKS END /////////
