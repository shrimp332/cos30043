Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vestibulum vehicula ex eu magna condimentum, at ultrices metus scelerisque. Praesent non nulla id augue convallis pretium.

## Cobol 

Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer nec odio. Praesent libero. Sed cursus ante dapibus diam.

### Hello world

```cobol
       IDENTIFICATION DIVISION.
       PROGRAM-ID. HELLO-WORLD.
       PROCEDURE DIVISION.
           DISPLAY "Hello, world!".
           STOP RUN.
```
Sed dignissim, sapien ut dignissim dictum, nisi urna luctus sapien, sed varius libero purus a tortor. Integer maximus, elit nec egestas pretium, dolor risus blandit enim, id efficitur leo erat sed urna.

### Adding Two Numbers

```cobol
       DATA DIVISION.
       WORKING-STORAGE SECTION.
       01 NUM1        PIC 9(3) VALUE 10.
       01 NUM2        PIC 9(3) VALUE 20.
       01 RESULT      PIC 9(4).
       
       PROCEDURE DIVISION.
           ADD NUM1 TO NUM2 GIVING RESULT.
           DISPLAY "Result is: " RESULT.
           STOP RUN.
```
Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed non risus. Suspendisse lectus tortor, dignissim sit amet, adipiscing nec, ultricies sed, dolor.
