import java.util.*;
import java.io.*;

import au.com.bytecode.opencsv.CSVReader;

public class ParseCSV
{
    public final static String OUTPUT_FILE_NAME = "results";
    public final static String FILE_EXTENSION = ".csv";
    
    // later, this array can be modified according to user's input reagarding the
    //   columns they want to modify
    public final static String[] TAR_COL_NAMES =
            {"Dry Bulb Temperature", "Dew Point Temperature", "Relative Humidity"};
    
    public int countLines(String srcFileName) throws FileNotFoundException
    {
        Scanner inFile = new Scanner(new File(srcFileName));
        
        int count = 0;
        
        try
        {
            while(inFile.nextLine() != null)
            {
                count++;
            }
        }
        catch (NoSuchElementException nsee)     // to handle the end-of-file exception
        {
            
        }
        
        return count;
    }
    
    public void loadCSV(String srcFileName, String desFileName, FileWriter outFile, char delimiter, String targetColumn)
    {
        try
        {
            CSVReader srcReader = new CSVReader(new FileReader(srcFileName), delimiter );
            CSVReader desReader = new CSVReader(new FileReader(desFileName), delimiter );
            
            int targetColumnNum = -1;   // first column in the .csv file starts from 0
            int targetRowNum = -1;    
            
            int numLines = countLines(srcFileName); // number of lines in the src file
            
            for (int line=0; line<numLines; line++)
            {
                String[] srcStrArray = srcReader.readNext();        // get one line
                String[] desStrArray = desReader.readNext();
                
                for ( int i = 0; i < srcStrArray.length; i++)       // iterate every item in current line
                {
                    if(srcStrArray[i].indexOf(targetColumn) != -1)
                    {
                        //to locate the target column and target row
                        targetColumnNum = i;
                        targetRowNum = line;
                    }

                    if( (i==targetColumnNum) && (line>(targetRowNum)) )
                    {
                        desStrArray[i] = srcStrArray[i];
                        
                        outFile.write(desStrArray[i] + delimiter);
                        continue;
                    }
                    
                    outFile.write(desStrArray[i] + delimiter);
                }
                
                outFile.write("\n");

            }
            
            /* ------------------------------------------------------------------------------- */
            
        }
        catch ( FileNotFoundException fnfe )
        {
            System.out.println(srcFileName + " not found!");
        }
        catch ( IOException ioe )
        {
            System.out.println("I/O Exception Error!");
        }
        
    }
    
    public static void main(String[] args) throws IOException
    {
        if(args.length < 1)
        {
            System.out.println("Error, usage: No file specified.");
            System.exit(1);
        }
        
        int numTargetColumns = TAR_COL_NAMES.length;
        
        for (int i=0; i<numTargetColumns; i++)
        {
            ParseCSV p = new ParseCSV();
            
            if (i == 0)                         // first column
            {
                FileWriter outFile = new FileWriter(new File(OUTPUT_FILE_NAME + "_" + i + FILE_EXTENSION));
                p.loadCSV(args[0], args[1], outFile, args[2].charAt(0), TAR_COL_NAMES[i]);
                outFile.close();
            }
            else if (i == numTargetColumns-1)   // middle columns
            {
                FileWriter outFile = new FileWriter(new File(OUTPUT_FILE_NAME + FILE_EXTENSION));
                p.loadCSV(args[0], OUTPUT_FILE_NAME + "_" + (i-1) + FILE_EXTENSION, outFile, args[2].charAt(0), TAR_COL_NAMES[i]);
                outFile.close();
            }
            else                                // last column
            {
                FileWriter outFile = new FileWriter(new File(OUTPUT_FILE_NAME + "_" + i + FILE_EXTENSION));
                p.loadCSV(args[0], OUTPUT_FILE_NAME + "_" + (i-1) + FILE_EXTENSION, outFile, args[2].charAt(0), TAR_COL_NAMES[i]);
                outFile.close();
            }
        }
        
        // clean up the intermediate result files
        for (int i=0; i<numTargetColumns-1; i++)
        {
            File toBeDeleted = new File(OUTPUT_FILE_NAME + "_" + i + FILE_EXTENSION);
            toBeDeleted.delete();
        }
    }
    
}