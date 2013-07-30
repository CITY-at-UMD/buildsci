import java.io.*;
import java.sql.*;
import java.util.*;

public class VirtualPULSE 
{
    public static final int NUM_ENTRIES = 100;  // number of records in database
                                                // number of buildings in database
    public static final String IN_FILE_NAME = "sql_result.txt";    // input file name
    
    public static void main(String[] args) throws SQLException, 
            ClassNotFoundException, InstantiationException, IllegalAccessException, IOException
    {
        System.out.println("Working dir: " + System.getProperty("user.dir"));
        
        // JDBC related data
        Class.forName("com.mysql.jdbc.Driver").newInstance();
        Connection myConnection_usrResults = 
                DriverManager.getConnection("jdbc:mysql://localhost:3306/UsrRslt", "root", "");
        Connection myConnection_oriData = 
                DriverManager.getConnection("jdbc:mysql://localhost:3306/OriData", "root", "");
        String testQuery_u = "select * from UsrRslt.year_2008";
        String testQuery_o = "select * from OriData.year_2008";
        Statement stmt_u = myConnection_usrResults.createStatement();
        Statement stmt_o = myConnection_oriData.createStatement();
        ResultSet results_u = stmt_u.executeQuery(testQuery_u);
        ResultSet results_o = stmt_o.executeQuery(testQuery_o);   

        // Read from file
        FileReader fr = new FileReader(IN_FILE_NAME);
        BufferedReader br = new BufferedReader(fr);
        String s;
        StringTokenizer st;
        Hashtable<String, Double> ht = new Hashtable();

        while( (s=br.readLine()) != null)
        {
            int i=0;
            st = new StringTokenizer(s);
            while(st.hasMoreTokens())
            {
                String item = st.nextToken();
                Double val = new Double(Double.parseDouble(st.nextToken()));
                ht.put(item, val);
            }
        }
        
        fr.close();

        Enumeration ek = ht.keys();
        Enumeration ev = ht.elements();
        
        while (ek.hasMoreElements()) {
            System.out.println(ek.nextElement());
        }
        
        while (ev.hasMoreElements()) {
            System.out.println(ev.nextElement());
        }
        //**********************************************************
        
        // containers for data retrieved from database
        
        // user simulation
        int[] building_ids_year_2008_u;
        int[] steam_jan_2008_u;
        int[] steam_feb_2008_u;
        int[] steam_mar_2008_u;
        int[] steam_apr_2008_u;
        
        // original data (from observation/real measurement)
        int[] building_ids_year_2008_o;
        int[] steam_jan_2008_o;
        int[] steam_feb_2008_o;
        int[] steam_mar_2008_o;
        int[] steam_apr_2008_o;
        int[] steam_may_2008_o;
        int[] steam_jun_2008_o;
        int[] steam_jul_2008_o;  
        int[] steam_aug_2008_o;
        int[] steam_sep_2008_o;
        int[] steam_oct_2008_o;
        int[] steam_nov_2008_o;
        int[] steam_dec_2008_o;  
        
        int[] electr_jan_2008_o;
        int[] electr_feb_2008_o;
        int[] electr_mar_2008_o;
        int[] electr_apr_2008_o;
        int[] electr_may_2008_o;
        int[] electr_jun_2008_o;
        int[] electr_jul_2008_o;  
        int[] electr_aug_2008_o;
        int[] electr_sep_2008_o;
        int[] electr_oct_2008_o;
        int[] electr_nov_2008_o;
        int[] electr_dec_2008_o;  
        
        int[] annual_electr;
        
        //*****************************************
        
        building_ids_year_2008_u = new int[NUM_ENTRIES];
        steam_jan_2008_u = new int[NUM_ENTRIES];
        steam_feb_2008_u = new int[NUM_ENTRIES];
        steam_mar_2008_u = new int[NUM_ENTRIES];
        steam_apr_2008_u = new int[NUM_ENTRIES];
        
        building_ids_year_2008_o = new int[NUM_ENTRIES];
         
        steam_jan_2008_o = new int[NUM_ENTRIES]; // steam_jan_2008_o[0] stores steam_jan data for building 0
        steam_feb_2008_o = new int[NUM_ENTRIES];
        steam_mar_2008_o = new int[NUM_ENTRIES];
        steam_apr_2008_o = new int[NUM_ENTRIES];
        steam_may_2008_o = new int[NUM_ENTRIES];
        steam_jun_2008_o = new int[NUM_ENTRIES];
        steam_jul_2008_o = new int[NUM_ENTRIES];  
        steam_aug_2008_o = new int[NUM_ENTRIES];
        steam_sep_2008_o = new int[NUM_ENTRIES];
        steam_oct_2008_o = new int[NUM_ENTRIES];
        steam_nov_2008_o = new int[NUM_ENTRIES];
        steam_dec_2008_o = new int[NUM_ENTRIES];  
        
        electr_jan_2008_o = new int[NUM_ENTRIES];
        electr_feb_2008_o = new int[NUM_ENTRIES];
        electr_mar_2008_o = new int[NUM_ENTRIES];
        electr_apr_2008_o = new int[NUM_ENTRIES];
        electr_may_2008_o = new int[NUM_ENTRIES];
        electr_jun_2008_o = new int[NUM_ENTRIES];
        electr_jul_2008_o = new int[NUM_ENTRIES];  
        electr_aug_2008_o = new int[NUM_ENTRIES];
        electr_sep_2008_o = new int[NUM_ENTRIES];
        electr_oct_2008_o = new int[NUM_ENTRIES];
        electr_nov_2008_o = new int[NUM_ENTRIES];
        electr_dec_2008_o = new int[NUM_ENTRIES];  
        
        annual_electr = new int[NUM_ENTRIES];
        //**********************************************************
        
        int iu = 0;     // iu is equivalent to building_id
        while (results_u.next())
        {
            building_ids_year_2008_u[iu] = results_u.getInt("building_id");
            steam_jan_2008_u[iu] = results_u.getInt("steam_jan");
            steam_feb_2008_u[iu] = results_u.getInt("steam_feb");
            steam_mar_2008_u[iu] = results_u.getInt("steam_mar");
            steam_apr_2008_u[iu] = results_u.getInt("steam_apr");
            
            //System.out.println(iu);   // DEBUG
            iu++;
        }
        
        // get the monthly steam consumption data from OriData
        int io = 0;
        while (results_o.next())
        {
            building_ids_year_2008_o[io] = results_o.getInt("building_id");
            steam_jan_2008_o[io] = results_o.getInt("steam_jan");
            steam_feb_2008_o[io] = results_o.getInt("steam_feb");
            steam_mar_2008_o[io] = results_o.getInt("steam_mar");
            steam_apr_2008_o[io] = results_o.getInt("steam_apr");
            steam_may_2008_o[io] = results_o.getInt("steam_may");
            steam_jun_2008_o[io] = results_o.getInt("steam_jun");
            steam_jul_2008_o[io] = results_o.getInt("steam_jul");
            steam_aug_2008_o[io] = results_o.getInt("steam_aug");
            steam_sep_2008_o[io] = results_o.getInt("steam_sep");
            steam_oct_2008_o[io] = results_o.getInt("steam_oct");
            steam_nov_2008_o[io] = results_o.getInt("steam_nov");
            steam_dec_2008_o[io] = results_o.getInt("steam_dec");
            
            electr_jan_2008_o[io] = results_o.getInt("electr_jan");
            electr_feb_2008_o[io] = results_o.getInt("electr_feb");
            electr_mar_2008_o[io] = results_o.getInt("electr_mar");
            electr_apr_2008_o[io] = results_o.getInt("electr_apr");
            electr_may_2008_o[io] = results_o.getInt("electr_may");
            electr_jun_2008_o[io] = results_o.getInt("electr_jun");
            electr_jul_2008_o[io] = results_o.getInt("electr_jul");
            electr_aug_2008_o[io] = results_o.getInt("electr_aug");
            electr_sep_2008_o[io] = results_o.getInt("electr_sep");
            electr_oct_2008_o[io] = results_o.getInt("electr_oct");
            electr_nov_2008_o[io] = results_o.getInt("electr_nov");
            electr_dec_2008_o[io] = results_o.getInt("electr_dec");
            
            io++;
        }
        // now io == number of buildings in the database
        
        // close the files
        results_u.close();
        results_o.close();
        stmt_u.close();
        stmt_o.close();
        myConnection_usrResults.close();
        myConnection_oriData.close();
        
        //*****************************************
        
        // sum up monthly data
        for(int b_id=0; b_id<io; b_id++)
        {
          
            annual_electr[b_id] =   electr_jan_2008_o[b_id] +
                                    electr_feb_2008_o[b_id] +
                                    electr_mar_2008_o[b_id] +
                                    electr_apr_2008_o[b_id] +
                                    electr_may_2008_o[b_id] +
                                    electr_jun_2008_o[b_id] +
                                    electr_jul_2008_o[b_id] +
                                    electr_aug_2008_o[b_id] +
                                    electr_sep_2008_o[b_id] +
                                    electr_oct_2008_o[b_id] +
                                    electr_nov_2008_o[b_id] +
                                    electr_dec_2008_o[b_id];  
        }
        
        for (int b_id=0; b_id<io; b_id++)
        {
            System.out.println("annual electricity consumption for building " + b_id + " is: " + annual_electr[b_id]);
        }
        
        for (int i=0; i<io; i++)
        {
            System.out.println("Building " + i + " The annual electricity usage between Ori and Simulation is: "
                     + Math.abs(annual_electr[i]- ht.get("electricity_total_end_uses")));
        }
        
        // monthly comparison
//        for (int i=0; i<io; i++)
//        {
//            System.out.println("Building " + i + " The steam_jan_2008 difference between usr and ori is: "
//                     + Math.abs(steam_jan_2008_u[i]- steam_jan_2008_o[i]));
//        }
        
     
    }
}
