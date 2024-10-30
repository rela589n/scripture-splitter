Scripture Splitter
-----

## Single chapter splitter

Create input file in `var/storage/`:

```shell
touch var/storage/john11.txt
```

Run verse splitter:

```shell
bin/console splitter:run "Івана 11" --inputFile=john11.txt --outputDir=john11/
```

See the generated files in `var/storage/john11/`.

## Range splitter

In `storage/matthew` create files `11.txt`, `12.txt`, `13.txt` etc. and then run:

```shell
bin/console splitter:run-range "Колосян" --workDir=colossians/ --range="1-4"
```
