import java.io.*;
import java.util.*;

import org.jsoup.*;

public class readHtml
{
    public final static String inFile = "eplustbl.htm";
    public final static String outFile = "MonthlyData.txt";
    public final static String tableHead =
        "\\<p\\>Report:\\<b\\> BUILDING MONTHLY COOLING LOAD REPORT\\<\\/b\\>\\<\\/p\\>";
    public final static String tableTail = "\\<\\/table\\>";
    
    public static void main(String[] args) throws IOException
    {
        BufferedReader in = new BufferedReader(new FileReader(inFile));
        FileWriter fwriter = new FileWriter(new File(outFile) );
        
        String lineBuffer = "";
        
        boolean isInMonthlyTable = false;
        
        int i = 0;
        while ( (lineBuffer = in.readLine()) != null)
        {
            // detect the beginning of a monthly data table
            if (lineBuffer.matches(tableHead))
            {
                String stripped = Jsoup.parse(lineBuffer).text();
                fwriter.write(stripped + "\n");
                isInMonthlyTable = true;    // turn the signal on
            }
            
            // process the table
            if (isInMonthlyTable)
            {                
                String stripped = Jsoup.parse(lineBuffer).text();
                fwriter.write(stripped + "\n");
            }
            
            // detect the end of the monthly data table
            if (lineBuffer.matches(tableTail) && isInMonthlyTable)
            {
                String stripped = Jsoup.parse(lineBuffer).text();
                fwriter.write(stripped + "\n");
                isInMonthlyTable = false;   // turn the signal off
            }
            
            i++;
        }
        
        in.close();
                                           
        fwriter.close();
    }

}