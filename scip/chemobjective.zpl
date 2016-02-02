# This is the objective function file. Not:hing here changes with input.

#Parameters first. These are the constants.
param deltahappy := 2600;
param rank_constant := 6;
param max_sections := 4;
param gamma1 := 1;
param gamma2 := 1;
param gamma3 := 1;

#Functions to clean up constraints below.

defnumb R (r) := (rank_constant)*(6-r);

# Variables. The IP can choose to make these whatever it wants to maximize the objective.
var x[T cross S]  binary;
var q[T cross C]  binary;
var y[T cross D]  binary;
#var beta[T cross S cross S] binary;

#The objective function. To be maximized by IP.
maximize satisfaction:
  sum <i> in T: R(ranking[i]) *(
(sum <j> in S:x[i,j]*pref[i,j])+
#a[i]*gamma1*((sum <j> in S:x[i,j])-(sum <k> in C: q[i,k]))+
b[i]*gamma2*((sum <j> in S:x[i,j])-(sum <d> in D: y[i,d]))
#+c[i]*gamma3*(2*(sum <j> in S:x[i,j])-(sum <j,z> in (S cross S):beta[i,j,z]))
);  

# Default constraints. These are not dependent on input.

# Every section needs exactly one TA
subto sections_covered:
  forall <j> in (S without PhantomSections) do
    sum <i> in T: x[i,j] == theta[j]; #theta[i] is ta requirement per section should it stay binary? That is, can a TA be assigned multiple times to the same section?

# Every TA must meet their teaching duties exactly
subto duties_met:
  forall <i> in (T without PhantomTAS) do
    sum <j> in S: weight[j]*x[i,j] == units[i];
#PhantomTAs must either 2 teach or 4 units
subto Phantom_duties:
  forall <i> in (T inter PhantomTAS) do
    sum <j> in S: weight[j]*x[i,j] <= 4;

#Makes sure there are no phantom pairs
subto No_Danny_Phantoms:
  forall <i,j> in ((T inter PhantomTAS) cross (S inter PhantomSections)) do
    x[i,j] == 0;
     
#makes sure TAs with 2 units don't teach 4 unit courses
subto Unit_overload:
  forall <i,j> in (T  cross (S without PhantomSections))  with weight[j]==4 and units[i]==2 do
  x[i,j]==0;

#subto 25_only:
# forall <i,j> in (T cross (S inter {008A,002A,002B,002C,002AH,002BH,008B,118B,118C,129A,130B}) ) with units[i]!=2 do
#   x[i,j]==0;


# No TA unsuited for upper div classes teaches upper div classes
subto lower_div_only:
  forall <i,j> in ((T inter LoTAS) cross (S inter (UpSections union GradSections))) do
    x[i,j] == 0;

# No TA unsuited for grad classes teaches grad classes
subto no_grad:
  forall <i,j> in ((T inter UpTAS) cross (S inter GradSections)) do
    x[i,j] == 0;

#q constraints

#No time spent determining q_ik for TAs that don't care
#subto q_3:
#    forall <i,k> in ((a_neutral inter T) cross C) do
#    q[i,k] == 0;
#
#subto q_1:
#  forall <i,k,j> in ((a_positive inter T) cross C cross S) do   
#    q[i,k] >= x[i,j]*deltacourse[j,k];
#
#
#subto q_2:
#    forall <i,k> in ((a_negative inter T) cross C) do
#    q[i,k] <= sum <j> in S: x[i,j]*deltacourse[j,k];    

#y constraints
subto y_1:
  forall <i,d,j> in ( T cross  D cross S) with b[i]== 1 do
    y[i,d] >= x[i,j]*deltaday[j,d];


subto y_2:
  forall <i,d> in (T cross D) with b[i]== -1 do
    y[i,d] <= sum <j> in S: x[i,j]*deltaday[j,d];

subto y_3:
forall <i,d> in  (T cross D) with b[i]== 0 do
   y[i,d] == 0;


# Makes sure TA is not assigned to sections that have the same times
subto no_overlap:
forall <i,j,z> in ( (T) cross (S without PhantomSections)  cross (S without PhantomSections))  with omega[j,z]==1 do
      x[i,j]+x[i,z] <= 1;

subto no_conflicts:
forall <i,j> in ( (T without PhantomTAS) cross (S without PhantomSections)) with omega2[i,j] == 1 do
      x[i,j] == 0;
