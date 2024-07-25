Scripture Splitter
-----

Create input file in `var/storage/`:

```shell
touch var/storage/john11.txt
```

Run verse splitter:

```shell
bin/console splitter:run "Івана 11" --inputFile=john11.txt --outputDir=john11/
```

See the generated files in `var/storage/john11/`.
