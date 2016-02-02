#include <cstdlib>
#include <iostream>
#include <fstream>
#include <sstream>
#include <string>
#include <vector>
#include <algorithm>
#include <functional>
#include <cctype>
#include <locale>
#include <cstring>

using namespace std;

char *strdup (const char *s) {
    char * d = (char *)malloc(strlen(s) + 1);   // Space for length plus null
    if (d == NULL) return NULL;          // No memory
    strcpy(d,s);                        // Copy the chars
    return d;
}

string normalize (string raw)
{
  string name;
  for(unsigned int i=0; i<raw.length(); i++)
  {
    if(raw[i] == '(' || raw[i] == '\r') break;
    name.push_back(raw[i]);
  } //stop at paranthesis
  return name;
} //normalize
 //quote
class Dictionary
{
public:
  string SCIP, TA, Section;
};


void input(vector<Dictionary>* key, char * infile, char * intermediate)
{
  FILE *fp;
    fp = fopen(infile, "r");
  FILE *f2;
    f2 = fopen(intermediate, "w");
    if(fp == NULL)
    {
      cout << "tbl file not readable.\n";
      exit(1);
    } //if file open error

  char line[1000];
  fgets(line, 999, fp);
  char * flag;
  char * flag2;
  string test, test2;
  
  while(!feof(fp))
  {
 //   Dictionary rosetta;
   
    flag = strtok(line," \t\r\n");
    flag =strtok(NULL," \t\r\n");
    flag =strtok(NULL," \t\r\n");
    flag =strtok(NULL,"\" \t\r\n");
    if (flag[0]=='x' && flag[1]=='$')
    { 
    flag2 =strtok(NULL,"\"\t\r\n");
    fprintf(f2, "%s\t%s\n", flag,flag2);
    }
    fgets(line, 999, fp);
  } //while still TAs to read in 
 fclose(fp);
 fclose(f2);
} 

void intermediato(vector<Dictionary>* key, char * intermediate)
{
  FILE * fp;
  fp = fopen(intermediate,"r");
  Dictionary rosetta;
  char line[1000];
  fgets(line, 999, fp);
  char * flag;
  string test, test2;

  while(!feof(fp))
  {

    flag = strtok(line," \t");
    rosetta.SCIP=flag;
    flag =strtok(NULL,"$");
    flag =strtok(NULL,"$");
    rosetta.TA=flag;
    flag =strtok(NULL,"\n");
    rosetta.Section=flag;
    key->push_back(rosetta);
    fgets(line, 999, fp);

  }

fclose(fp);

}
/*
void output(vector<Dictionary>* key, char * SCIPFile, char * outfile)
{
FILE * fp;
FILE * f2; 
fp=fopen(SCIPFile,"r");
f2=fopen(outfile,"w");
char line[1000];
fgets(line, 999, fp);
char * flag;
string sflag;
fprintf(f2,"TA,Section,\r\n");
  while(!feof(fp))
  {

    flag=strtok(line,"\t ");
    sflag=flag;
    if (flag[0]=='x')
    {
      for(unsigned int i=0;i<key->size(); i++)
        if (sflag.compare((key->at(i)).SCIP)==0)
          fprintf(f2, "%s,%s,\r\n",(key->at(i)).TA.c_str(),(key->at(i)).Section.c_str());

    }
    fgets(line, 999, fp);
  }
fclose(fp);
fclose(f2);

}
*/

void output(vector<Dictionary>* key, char * SCIPFile/*, char * outfile*/)
{
FILE * fp;
FILE * f2;
fp=fopen(SCIPFile,"r");
//f2=fopen(outfile,"w");
char line[1000];
fgets(line, 999, fp);
char * flag;
string sflag;
cout << "TA,Section,\r\n";
  while(!feof(fp))
  {

    flag=strtok(line,"\t ");
    sflag=flag;
    if (flag[0]=='x')
    {
      for(unsigned int i=0;i<key->size(); i++)
        if (sflag.compare((key->at(i)).SCIP)==0)
          cout << (key->at(i)).TA <<"," <<  (key->at(i)).Section << ",\r\n";

    }
    fgets(line, 999, fp);
  }
fclose(fp);
//fclose(f2);

}


int main(int argc, char * argv[])
{
  char intermediate[]= "Intermediate.txt";
  char inputtable[] = "input.tbl";
  char out[] = "out.txt";
  vector<Dictionary> key;
  input(&key, inputtable ,intermediate);
  intermediato(&key,intermediate);
  output(&key, out/*,argv[3]*/);
  return 0;
} 
