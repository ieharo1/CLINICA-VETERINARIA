using System;
using System.Collections.Generic;
using System.Data;
using System.Linq;
using System.Text;
using System.Threading.Tasks;

namespace POO6
{
    class Program
    {
        static void Main(string[] args)
        {

            ConexionAccess con = new ConexionAccess("Database1.accdb");

            con.open();

            DataSet d = con.executeQuery("SELECT * FROM clientes");

            foreach (DataRow row in d.Tables[0].Rows)
            {
                Console.WriteLine("ID: " + row["ID"]);
                Console.WriteLine("nombre: " + row["nombre"]);
                Console.WriteLine("apellidos: " + row["apellidos"]);
                Console.WriteLine("edad: " + row["edad"]);
                Console.WriteLine();
            }


            con.close();
            Console.ReadLine();
        }
    }
}
