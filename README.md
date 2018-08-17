<h1 align="center">PHP RRDTool Helpers</h1>
<p align="center"><em>Ease the creation and updating of rrdtools files</em></p>

<p align="center">
  <a href="https://packagist.org/packages/photogabble/php-rrd-tool"><img src="https://img.shields.io/packagist/v/photogabble/php-rrd-tool.svg" alt="Latest Stable Version"></a>
  <a href="LICENSE"><img src="https://img.shields.io/github/license/photogabble/php-confusable-homoglyphs.svg" alt="License"></a>
</p>

## About this package

I wrote this library to help my understanding of how RRDTool commands work. It acts as a class based container that can easily be configured and then cast to a string to return the command line input.

It currently only contains a class representation of [rrdcreate](https://oss.oetiker.ch/rrdtool/doc/rrdcreate.en.html).

I am aware of the [php-rrd](http://php.net/manual/en/book.rrd.php) extension and do use it in other contexts. However this library may be useful on systems where that extension isn't available but RRDTools is.

## Install

Install this library with composer: `composer require photogabble/php-rrd-tool`.

## Usage

Please see the [tests](https://github.com/photogabble/php-rrd-tool/tree/master/tests) for detailed example of usage.

## Todo

* [x] Add class representation of [rrdupdate](https://oss.oetiker.ch/rrdtool/doc/rrdupdate.en.html)
* [ ] Add class representation of [rrddump](https://oss.oetiker.ch/rrdtool/doc/rrddump.en.html)
* [ ] Add class representation of [rrdfetch](https://oss.oetiker.ch/rrdtool/doc/rrdfetch.en.html)
* [ ] Add class representation of [rrdfirst](https://oss.oetiker.ch/rrdtool/doc/rrdfirst.en.html)
* [ ] Add class representation of [rrdgraph](https://oss.oetiker.ch/rrdtool/doc/rrdgraph.en.html)
* [ ] Add class representation of [rrdinfo](https://oss.oetiker.ch/rrdtool/doc/rrdinfo.en.html)
* [ ] Add class representation of [rrdlast](https://oss.oetiker.ch/rrdtool/doc/rrdlast.en.html)
* [ ] Add class representation of [rrdlastupdate](https://oss.oetiker.ch/rrdtool/doc/rrdlastupdate.en.html)
* [ ] Add class representation of [rrdresize](https://oss.oetiker.ch/rrdtool/doc/rrdresize.en.html)
* [ ] Add class representation of [rrdrestore](https://oss.oetiker.ch/rrdtool/doc/rrdrestore.en.html)
* [ ] Add class representation of [rrdtune](https://oss.oetiker.ch/rrdtool/doc/rrdtune.en.html)
* [ ] Add class representation of [rrdxport](https://oss.oetiker.ch/rrdtool/doc/rrdxport.en.html)
* [ ] Add missing specialized functions `HWPREDICT`, `MHWPREDICT`, etc
